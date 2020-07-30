<?php
/**
 * Easy Digital Downloads Theme Updater
 *
 * @package EDD Sample Theme
 */

// Includes the files needed for the theme updater
if (!class_exists('EDD_Theme_Updater_Admin')) {
	include (dirname(__FILE__).'/theme-updater-admin.php');
}

// Loads the updater classes
$updater = new EDD_Theme_Updater_Admin(

	// Config settings
	$config = array(
		'remote_api_url' => 'https://www.afthemes.com', // Site where EDD is hosted
		'item_name'      => 'StoreCommerce Pro', // Name of theme
		'theme_slug'     => 'storecommerce-pro', // Theme slug
		'version'        => '1.1.6', // The current version of this theme
		'author'         => 'AF themes', // The author of this theme
		'download_id'    => '', // Optional, used for generating a license renewal link
		'renew_url'      => 'https://afthemes.com/my-profile/'// Optional, allows for a custom license renewal link
	),

	// Strings
	$strings = array(
		'theme-license'             => __('Theme License', 'storecommerce'),
		'enter-key'                 => __('Enter your theme license key.', 'storecommerce'),
		'license-key'               => __('License Key', 'storecommerce'),
		'license-action'            => __('License Action', 'storecommerce'),
		'deactivate-license'        => __('Deactivate License', 'storecommerce'),
		'activate-license'          => __('Activate License', 'storecommerce'),
		'status-unknown'            => __('License status is unknown.', 'storecommerce'),
		'renew'                     => __('Renew?', 'storecommerce'),
		'unlimited'                 => __('unlimited', 'storecommerce'),
		'license-key-is-active'     => __('License key is active.', 'storecommerce'),
		'expires%s'                 => __('Expires %s.', 'storecommerce'),
		'%1$s/%2$-sites'            => __('You have %1$s / %2$s sites activated.', 'storecommerce'),
		'license-key-expired-%s'    => __('License key expired %s.', 'storecommerce'),
		'license-key-expired'       => __('License key has expired.', 'storecommerce'),
		'license-keys-do-not-match' => __('License keys do not match.', 'storecommerce'),
		'license-is-inactive'       => __('License is inactive.', 'storecommerce'),
		'license-key-is-disabled'   => __('License key is disabled.', 'storecommerce'),
		'site-is-inactive'          => __('Site is inactive.', 'storecommerce'),
		'license-status-unknown'    => __('License status is unknown.', 'storecommerce'),
		'update-notice'             => __("Updating this theme will lose any customizations you have made. 'Cancel' to stop, 'OK' to update.", 'storecommerce'),
		'update-available'          => __('<strong>%1$s %2$s</strong> is available. <a href="%3$s" class="thickbox" title="%4s">Check out what\'s new</a> or <a href="%5$s"%6$s>update now</a>.', 'storecommerce')
	)

);
