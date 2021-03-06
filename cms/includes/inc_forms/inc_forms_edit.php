<?php

############################################################################################################################
## Edit FAQ Item
############################################################################################################################

function edit_item()
{

    global $message,$id,$do,$disable_menu,$valid,$htmladmin, $main_subheading, $js_vars, $admin_dir;

    $disable_menu = "true";

    $sql = "SELECT `name`, `email_subject`, `success_message`, `mailchimp_list_id`, 
        `terms_and_conditions`, `xml_data`, `json_data`
        FROM `form`
        WHERE `id` = '{$id}'
        LIMIT 1";

    $row = fetch_row($sql);


    @extract($row);


    $js_vars['data']['formId'] = $id;

    ##------------------------------------------------------------------------------------------------------
    ## Page functions

    $page_functions = <<< HTML
    <ul class="page-action">
        <li><button type="button" class="btn btn-default" id="save-changes"><i class="glyphicon glyphicon-floppy-save"></i> Save</button></li>
        <li><a class="btn btn-default" href="{$htmladmin}/?do={$do}"><i class="glyphicon glyphicon-arrow-left"></i> Cancel</a>
        </li>
    </ul>
HTML;


##------------------------------------------------------------------------------------------------------
## Settings tab content
$settings_content = <<< HTML
    <table width="100%" border="0" cellspacing="0" cellpadding="8">
        <tr>
            <td width="130" valign="top"><label for="name">Name:</label></td>
            <td valign="top">
                <input name="cms_name" id="cms_name" value="$name" style="width:300px;" />
            </td>
        </tr>
        <tr>
            <td width="130" valign="top"><label for="code">Mailchimp List ID:</label></td>
            <td valign="top">
                <input name="mailchimp_list_id" id="mailchimp_list_id" value="$mailchimp_list_id" style="width:300px;" />
            </td>
        </tr>
        <tr>
            <td width="130" valign="top"><label for="email_subject">Email Subject:</label></td>
            <td valign="top">
                <input name="email_subject" id="email_subject" value="$email_subject" style="width:800px;" />
            </td>
        </tr>
        <tr>
            <td width="130" valign="top" colspan="4">
                <label for="success_message">Success Message:</label>
                <textarea name="success_message" id="success_message" style="width:100%;height:150px;resize:none;">{$success_message}</textarea>
            </td>
        </tr>
        <tr>
            <td width="130" valign="top" colspan="4">
                <label for="terms_and_conditions">Terms & Conditions:</label>
                <textarea name="terms_and_conditions" id="terms_and_conditions">{$terms_and_conditions}</textarea>
                <script>
                    CKEDITOR.replace( 'terms_and_conditions', {
                        toolbar : 'MyToolbar',
                        forcePasteAsPlainText : true,
                        resize_enabled : false,
                        height : 600,
                        filebrowserBrowseUrl : jsVars.dataManagerUrl
                    });
                </script>
            </td>
        </tr>

    </table>
HTML;


require_once 'views/fields.php';
require_once 'views/entries.php';


##------------------------------------------------------------------------------------------------------
## tab arrays and build tabs

$temp_array_menutab = array();

$temp_array_menutab['Details'] = $settings_content;
$temp_array_menutab['Fields']  = $fields_content;
$temp_array_menutab['Entries'] = $entries_content;

$counter     = 0;
$tablist     = "";
$contentlist = "";

foreach($temp_array_menutab as $key => $value)
{

	$tablist.= "<li><a href=\"#tabs-".$counter."\">".$key."</a></li>";

	$contentlist.=" <div id=\"tabs-".$counter."\">".$value."</div>";

	$counter++;
}

$tablist="<div id=\"tabs\"><ul>$tablist</ul><div style=\"padding:10px;\">$contentlist</div></div>";

    $page_contents="<form action=\"$htmladmin/?do={$do}\" method=\"post\" name=\"pageList\" enctype=\"multipart/form-data\">
        $tablist
        <input type=\"hidden\" name=\"action\" value=\"\" id=\"action\">
        <input type=\"hidden\" name=\"do\" value=\"{$do}\">
        <input type=\"hidden\" name=\"id\" value=\"$id\">
        <input type=\"hidden\" name=\"meta_data_id\" value=\"$id\">
    </form>";
require "resultPage.php";
echo $result_page;
exit();

}

?>
