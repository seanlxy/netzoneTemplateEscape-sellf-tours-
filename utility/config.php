<?php

$cms_version = '4.2';

############################################################################################################################
## Environment Settings
############################################################################################################################

$fromroot = '';

$is_local     = true;
$debug        = false;

$htmlrootfull = "http://tour.loc";
$admin_dir    = 'cms';
$httpsadmin   = "http://".$_SERVER['HTTP_HOST'].$fromroot.'/'.$admin_dir;
$rootfull     = $_SERVER['DOCUMENT_ROOT'];

$root         = "$rootfull$fromroot";
$rootadmin    = "$root/{$admin_dir}";
$htmlroot     = "{$htmlrootfull}{$fromroot}";
$htmladmin    = "{$htmlroot}{$fromroot}/{$admin_dir}";

$db_host      = 'localhost';
$db_user      = 'root';
$db_pwd       = '';
$db_name      = 'tour_db';

############################################################################################################################
## Constants
############################################################################################################################

if( !defined('ADMIN_BASE_URL'))         define('ADMIN_BASE_URL', $htmlrootfull.'/'.$admin_dir);
if( !defined('GC_SITE_KEY'))            define('GC_SITE_KEY', '6LdBBUEUAAAAAFR06sAxDP3s9Iz2l_amQCmHxNeP');
if( !defined('GC_SECRET_KEY'))          define('GC_SECRET_KEY', '6LdBBUEUAAAAAF__JxP0laDiCjK4tbAcKlnCX_V7');
if( !defined('DD_FLAG') )               define('DD_FLAG', 'D'); // DD = Drop Down
if( !defined('CONTENT_FLAG') )          define('CONTENT_FLAG', 'C');

if(!defined('THUMB_WIDTH'))             define('THUMB_WIDTH', 620);
if(!defined('THUMB_HEIGHT'))            define('THUMB_HEIGHT', 480);

if(!defined('THUMB_WIDTH_ALT'))         define('THUMB_WIDTH_ALT', 650);
if(!defined('THUMB_HEIGHT_ALT'))        define('THUMB_HEIGHT_ALT', 450);

if(!defined('GALLERY_THUMB_WIDTH'))     define('GALLERY_THUMB_WIDTH', 620);
if(!defined('GALLERY_THUMB_HEIGHT'))    define('GALLERY_THUMB_HEIGHT', 480);

############################################################################################################################
## Directories
############################################################################################################################

## Image Directory
$imgurl          = "$root/library";
$imgurl_admin    = "$rootadmin/library";
$imgurl_html     = "$htmlroot/images";

## Template Directory
$tmpldir         = "$root/templates";
$tmpldir_admin   = "$rootadmin/templates";
$tmpldir_html    = "$htmlroot/templates";

## Modules Directory
$moddir          = "$root/modules";
$moddir_html     = "$htmlroot/modules";
$moddir_admin    = "$rootadmin/modules";

## Includes Directory
$incdir          = "$root/includes";
$incdir_admin    = "$rootadmin/includes";

## functions Directory
$funcdir         = "$root/functions";
$funcdir_admin   = "$rootadmin/functions";

## Utility Directory
$utildir         = "$root/utility";
$utildir_admin   = "$rootadmin/utility";

## Assets Directory
$assetsdir       = "$root/assets";
$assetsdir_admin = "$rootadmin/assets";

## Services Directory
$classdir        = "$root/classes";
$classdir_admin  = "$rootadmin/classes";

## AJAX Directory
$ajaxdir         = "$root/ajax";
$ajaxdir_admin   = "$rootadmin/ajax";
$ajaxdir_html    = "$htmlroot/ajax";

## Creating the Database Connections
@include_once("CConnection.php");

include_once($funcdir.'/func_all.php');

## To use another directory just add the prefix of the directory variable (in this case 'funcdir')
$c_Connection = new CConnection();
$c_Connection->Configure($db_host, $db_name, $db_user, $db_pwd);


############################################################################################################################
## Script Processing
############################################################################################################################

## Error Reporting?
$error_reporting  = 'Y';
## Notice Reporting?
$notice_reporting = 'N';

if(strtolower($error_reporting)=='y')
{
    if(strtolower($notice_reporting)=='y')
    {
        ini_set('error_reporting', E_ALL);
    }
    else
    {
        ini_set('error_reporting', E_ALL & ~E_NOTICE);
    }
    ini_set('display_errors', E_ALL);
}
else
{
    ini_set('display_errors', E_ALL);
}


?>
