<?php
// die;
## ----------------------------------------------------------------------------------------------------------------------
## NetZone 1.0
## index.php
##
## Author: Sam Walsh, Ton Jo Immanuel, Tomahawk Brand Management Ltd.
## Date: 19 May 2010
##
## Main Page
## ----------------------------------------------------------------------------------------------------------------------
session_start();

###############################################################################################################################
## Required Files
###############################################################################################################################

require_once ('../utility/config.php');                                 ## System config file (in the main folder)

define('MAX_COLUMNS', 4);

$upload_dir          = 'uploads/'.date('Y/m');
$upload_dirs         = explode('/', $upload_dir);
$upload_dir_fullpath = "{$rootfull}/{$upload_dir}";

$dir_str = '';

if( !is_dir($upload_dir_fullpath) )
{
    foreach($upload_dirs as $dir)
    {
        if($dir)
        {
            $dir_str .= '/'.$dir;

           if(!is_dir("$rootfull{$dir_str}")) mkdir("$rootfull{$dir_str}", 0755);
        }
    }
}

$upload_dir = '/'.$upload_dir;

############################################################################################################################
## Get the query string and split the name value pairs
############################################################################################################################

global $do, $session, $action, $disable_menu;

$siteUserIdHash   = $_COOKIE['siteUserId'];


$do           = filter_var($_REQUEST['do'], FILTER_CALLBACK, array('options' => 'is_lower_alpha'));
$session      = filter_var($siteUserIdHash);
$action       = filter_var($_REQUEST['action'], FILTER_CALLBACK, array('options' => 'is_lower_alpha'));
$id           = filter_var($_REQUEST['id'], FILTER_VALIDATE_INT);
$disable_menu = ($_REQUEST['disable_menu'] == 'true') ? true : false;
$js_vars      = array();
$login_cls    = '';

include_once("$incdir_admin/inc_login/inc_login.php");                      ## used to login, logout and check for valid session

############################################################################################################################
## GET USER DETAILS
############################################################################################################################
if(!empty($siteUserIdHash)){

    $sqlUser = "SELECT `user_id`, `user_fname`, `user_lname`, `user_email`,
        `last_login_date`, `access_id`, `is_superuser`
        FROM `cms_users`
        WHERE SHA1(`user_id`) = '{$siteUserIdHash}'
        LIMIT 1";

    $siteUserDetails = fetch_row($sqlUser);

    if(!empty($siteUserDetails)){

        $siteUserId       = $siteUserDetails['user_id'];
        $siteUserFname    = $siteUserDetails['user_fname'];
        $siteUserLname    = $siteUserDetails['user_lname'];
        $siteUserEmail    = $siteUserDetails['user_email'];
        $siteUserAccessId = $siteUserDetails['access_id'];
        $siteSuperUser    = $siteUserDetails['is_superuser'];

    }
}

############################################################################################################################
## Find out what the &do value is from the query string and "do" what the user wants
############################################################################################################################

$page_contents = "";

$sql = "SELECT `cmsset_name`, `cmsset_value`
FROM `cms_settings`
WHERE `cmsset_status` = 'A'";

$settings_result = fetch_all($sql);

## Get all of the CMS settings
foreach($settings_result AS $row)
{
    ${$row['cmsset_name']} = $row['cmsset_value'];                ## Convert the settings into variables
}

if($do == 'login' && !empty($action)){

    switch($action)
    {
        case 'forgot':
            do_forgot_password();
            break;
        case 'reset':
            do_reset_password();
            break;
        case 'resetsuccess':
            do_reset_success_email();
            break;
        default:
            display_login_screen();
            break;
    }

    require "resultPage.php";
    echo $result_page;
    exit();

}elseif($do == 'login'){

    do_login();                                                         ## >> inc_login.php
    $do = 'dashboard';                                                     ## If the value of do is "login" change it to "pages"

    $page_contents = (!empty($message) && $valid == 0) ? '<div class="alert alert-danger"><strong>'.$message.'</strong></div>' : '';
    $login_cls     = (!empty($message) && $valid == 0) ? ' invalid' : '' ;

} elseif($do == 'logout') {

    do_logout();                                                        ## >> inc_login.php
    $page_contents = (!empty($message)) ? '<div class="alert alert-success"><strong>'.$message.'</strong></div>' : '';

} elseif($session != "") {

    $valid = check_session();                                           ## >> inc_login.php
    $do    = (!empty($do)) ? $do : 'dashboard';

} else {

    $valid = 0;                                                         ## user is not logged in
}

if($do != "" && $valid == 1)            ## user has logged in and has a valid login session....
{
    define(USER_ID,    $siteUserId );
    define(USER_FNAME, $siteUserFname);
    define(USER_LNAME, $siteUserLname);
    define(USER_EMAIL, $siteUserEmail);
    define(ACCESS_ID,  $siteUserAccessId);
    define(IS_SUPER_USER,  $siteSuperUser);

    $s_access_id = ACCESS_ID;
    $sql = "SELECT *
        FROM cms_accessgroups
        WHERE access_id = '$s_access_id'";

    $access_arr = fetch_row($sql);

    include_once('access.php');

    $defaultSettings = array();

    if(ACCESS_SETTINGS == 'Y'){
        $menuPages[] = 'settings';
    }
    if(ACCESS_USERS == 'Y'){
        $menuPages[] = 'users';
    }
    if(ACCESS_ACCESSGROUPS == 'Y'){
        $menuPages[] = 'accessgroups';
    }
    if(ACCESS_CMSSETTINGS == 'Y'){
        $menuPages[] = 'cmssettings';
    }
    $menuPages[] = 'sitemap';
    $menuPages[] = 'redirects';

    $moduleGroupsQuerySqlExt = (IS_SUPER_USER != 'Y') ? "AND cmg.`is_active` = 'Y'" : "";

    $moduleGroups = fetch_value("SELECT cm.`cms_module_uri`
                    FROM `cms_module_group` cmg
                    LEFT JOIN `cms_module` cm
                    ON(cmg.`cms_module_group_id` = cm.`cms_module_group_id`)
                    WHERE cm.`cms_module_uri` = '{$do}'
                    {$moduleGroupsQuerySqlExt}
                    ");

    if (!empty($moduleGroups) || in_array($do,$menuPages)) {

        $module_path = "includes/inc_$do/inc_$do.php";
        ## Get the include file from the do variable, load it in
        ## and run the main subroutine.
        if(file_exists($module_path) && !is_dir($module_path))
        {
            include_once $module_path;

            do_main();
        }
        else
        {
            die('<pre>#Invalid request</pre>');
        }
    }else{
        die('<pre>#Invalid Request. <br>#Please contact tomahawk to activate this feature</pre>');
    }





} else{

    display_login_screen();                                        ## user is not logged in so give them the login page
}


require "resultPage.php";                                               ## goes through all of the template tags & replaces them with PHP-processed variables
echo $result_page;                                                      ## echo the final page with all of the replaced template-tags

?>
