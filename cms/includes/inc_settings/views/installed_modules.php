<?php

$modules = fetch_all("SELECT `cms_module_group_id`,
                    `cms_module_group_label`,
                    `cms_module_description`,
                    `is_active`,
                    `rank`,
                    `cms_nav_group_id`
                    FROM `cms_module_group`");

$activeModulesView = '';
$inactiveModulesView = '';
$i = 1;
$j = 1;
foreach ($modules as $module) {
    if (IS_SUPER_USER == 'Y') {

        if($module['is_active'] == 'Y'){ $checked = 'checked'; }else{ $checked = ''; }

        $status = "<input type=\"checkbox\" name=\"is_active[{$module['cms_module_group_id']}]\" class=\"onoffcheckbox\" $checked />";

    }else{
        if ($module['is_active'] == "Y") { $status = '<span class="label label-success">Active</span>'; }
        if ($module['is_active'] == "N") { $status = '<span class="label label-warning">Inactive</span><br><a href="https://tomahawk.zendesk.com/hc/en-us/requests/new" target="_blank">Request Module</a>'; }
    }

    if ($module['is_active'] == 'Y') {

        $activeModulesView .= '<tr>
                <td width="30" style="padding-top:7px;padding-bottom:7px;">
                '.$i.'
                </td>
                <td width="250" style="padding-top:7px;padding-bottom:7px;">
                '.$module['cms_module_group_label'].'
                </td>
                <td style="padding-top:7px;padding-bottom:7px;">
                '.$module['cms_module_description'].'
                </td>
                <td width="100">
                '.$status.'
                </td>
            </tr>';

        $i++;
    }else {
        $inactiveModulesView .= '<tr>
                <td width="30" style="padding-top:7px;padding-bottom:7px;">
                '.$j.'
                </td>
                <td width="250" style="padding-top:7px;padding-bottom:7px;">
                '.$module['cms_module_group_label'].'
                </td>
                <td style="padding-top:7px;padding-bottom:7px;">
                '.$module['cms_module_description'].'
                </td>
                <td width="150">
                '.$status.'
                </td>
            </tr>';

        $j++;
    }
}

$installedModulesView.= <<< HTML
        <label class="design-tab-label">Installed Modules:</label>
        <table width="100%" class="bordered installed-modules-tbl">
            <thead>
                <tr>
                    <th style="padding-top:10px;padding-bottom:10px;" align="left"></th>
                    <th style="padding-top:10px;padding-bottom:10px;" align="left">Module Name</th>
                    <th style="padding-top:10px;padding-bottom:10px;" align="left">Description</th>
                    <th align="left">Installed</th>
                </tr>
            </thead>
            <tbody>
                {$activeModulesView}
            </tbody>
        </table>

        <label class="design-tab-label">Additional Modules:</label>
        <table width="100%" class="bordered installed-modules-tbl">
            <thead>
                <tr>
                    <th style="padding-top:10px;padding-bottom:10px;" align="left"></th>
                    <th style="padding-top:10px;padding-bottom:10px;" align="left">Module Name</th>
                    <th style="padding-top:10px;padding-bottom:10px;" align="left">Description</th>
                    <th align="left">Installed</th>
                </tr>
            </thead>
            <tbody>
                {$inactiveModulesView}
            </tbody>
        </table>
HTML;




?>
