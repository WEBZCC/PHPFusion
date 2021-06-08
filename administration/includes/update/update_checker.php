<?php
/*-------------------------------------------------------+
| PHPFusion Content Management System
| Copyright (C) PHP Fusion Inc
| https://phpfusion.com/
+--------------------------------------------------------+
| Filename: update_checker.php
| Author: RobiNN
+--------------------------------------------------------+
| This program is released as free software under the
| Affero GPL license. You can redistribute it and/or
| modify it under the terms of this license which you
| can read by viewing the included agpl.txt or online
| at www.gnu.org/licenses/agpl.html. Removal of this
| copyright header is strictly prohibited without
| written permission from the original author(s).
+--------------------------------------------------------*/
defined('IN_FUSION') || exit;

/**
 * Ajax update checker
 */
function ajax_update_checker() {
    $locale = fusion_get_locale('', [LOCALE.LOCALESET.'admin/main.php', LOCALE.LOCALESET.'admin/upgrade.php']);
    $settings = fusion_get_settings();

    if (
        ($settings['update_checker'] == 1 && ($settings['update_last_checked'] < (time() - 21600))) || // check every 6 hours
        (check_get('force') && get('force') == 'true')
    ) {
        dbquery("UPDATE ".DB_SETTINGS." SET settings_value=:time WHERE settings_name=:name", [':time' => time(), ':name' => 'update_last_checked']);

        $update = new PHPFusion\Update();
        $version = $update->checkUpdate(TRUE);

        if (!empty($version) && version_compare($version, $settings['version'], '>')) {
            $text = sprintf($locale['new_update_avalaible'], $version);
            $text .= ' <a class="btn btn-primary btn-sm m-l-10" href="'.ADMIN.'upgrade.php'.fusion_get_aidlink().'">'.$locale['update_now'].'</a>';

            $result = ['result' => $text];
        } else {
            $result = ['result' => $locale['U_006']];
        }

        header('Content-Type: application/json');
        echo json_encode($result);
    }
}

/**
 * @uses ajax_update_checker()
 */
fusion_add_hook('fusion_admin_hooks', 'ajax_update_checker');
