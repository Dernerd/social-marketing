<?php
/*
Plugin Name: PS Social Marketing
Plugin URI: https://n3rds.work/piestingtal-source-project/ps-social-marketing/
Description: Marketing in sozialen Netzwerken.
Version: 1.3.1
Author: WMS N@W
Author URI: https://n3rds.work
Text Domain: wdsm


Copyright 2020 WMS N@W (https://n3rds.work)
Author - DerN3rd (WMS N@W)
This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License (Version 2 - GPLv2) as published by
the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/

define ('WDSM_PLUGIN_SELF_DIRNAME', basename(dirname(__FILE__)));

//Setup proper paths/URLs and load text domains
if (is_multisite() && defined('WPMU_PLUGIN_URL') && defined('WPMU_PLUGIN_DIR') && file_exists(WPMU_PLUGIN_DIR . '/' . basename(__FILE__))) {
	define ('WDSM_PLUGIN_LOCATION', 'mu-plugins', true);
	define ('WDSM_PLUGIN_BASE_DIR', WPMU_PLUGIN_DIR, true);
	define ('WDSM_PLUGIN_URL', WPMU_PLUGIN_URL, true);
	$textdomain_handler = 'load_muplugin_textdomain';
} else if (defined('WP_PLUGIN_URL') && defined('WP_PLUGIN_DIR') && file_exists(WP_PLUGIN_DIR . '/' . WDSM_PLUGIN_SELF_DIRNAME . '/' . basename(__FILE__))) {
	define ('WDSM_PLUGIN_LOCATION', 'subfolder-plugins');
	define ('WDSM_PLUGIN_BASE_DIR', WP_PLUGIN_DIR . '/' . WDSM_PLUGIN_SELF_DIRNAME);
	define ('WDSM_PLUGIN_URL', plugins_url(WDSM_PLUGIN_SELF_DIRNAME));
	$textdomain_handler = 'load_plugin_textdomain';
} else if (defined('WP_PLUGIN_URL') && defined('WP_PLUGIN_DIR') && file_exists(WP_PLUGIN_DIR . '/' . basename(__FILE__))) {
	define ('WDSM_PLUGIN_LOCATION', 'plugins', true);
	define ('WDSM_PLUGIN_BASE_DIR', WP_PLUGIN_DIR, true);
	define ('WDSM_PLUGIN_URL', plugins_url(), true);
	$textdomain_handler = 'load_plugin_textdomain';
} else {
	// No textdomain is loaded because we can't determine the plugin location.
	// No point in trying to add textdomain to string and/or localizing it.
	wp_die(__('Es gab ein Problem beim Bestimmen, wo das Social Marketing-Plugin installiert ist. Bitte erneut installieren.'));
}
$textdomain_handler('wdsm', false, WDSM_PLUGIN_SELF_DIRNAME . '/languages/');

require_once WDSM_PLUGIN_BASE_DIR . '/lib/class_wdsm_installer.php';
Wdsm_Installer::check();

require_once WDSM_PLUGIN_BASE_DIR . '/lib/wdsm_exceptions.php';
require_once WDSM_PLUGIN_BASE_DIR . '/lib/class_wdsm_codec.php';
require_once WDSM_PLUGIN_BASE_DIR . '/lib/class_wdsm_social_marketing.php';
Wdsm_SocialMarketing::init();

// Widgets
require_once WDSM_PLUGIN_BASE_DIR . '/lib/class_wdsm_widget.php';
//add_action('widgets_init', create_function('', "register_widget('Wdsm_WidgetAdvert');"));
function Wdsm_init_WidgetAdvert ()
{
	return register_widget('Wdsm_WidgetAdvert');
}
add_action('widgets_init', 'Wdsm_init_WidgetAdvert');

if (is_admin()) {
	require_once WDSM_PLUGIN_BASE_DIR . '/lib/class_wdsm_tutorial.php';
	Wdsm_Tutorial::serve();

	require_once WDSM_PLUGIN_BASE_DIR . '/lib/class_wdsm_contextual_help.php';
	Wdsm_ContextualHelp::serve();
	
	require_once WDSM_PLUGIN_BASE_DIR . '/lib/class_wdsm_admin_form_renderer.php';
	require_once WDSM_PLUGIN_BASE_DIR . '/lib/class_wdsm_admin_pages.php';
	Wdsm_AdminPages::serve();
} else {
	require_once WDSM_PLUGIN_BASE_DIR . '/lib/class_wdsm_public_pages.php';
	Wdsm_PublicPages::serve();
}
require 'lib/external/plugin-update-checker/plugin-update-checker.php';
$MyUpdateChecker = Puc_v4_Factory::buildUpdateChecker(
	'https://n3rds.work//wp-update-server/?action=get_metadata&slug=social-marketing', 
	__FILE__, 
	'social-marketing' 
);