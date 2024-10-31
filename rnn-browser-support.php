<?php
/*
Plugin Name: RNN Browser Support
Description: Easy way to inform people that their browser might not support every element on the site.
Version: 1.0.3
Author: ResenNet
Text Domain: rnn-browser-support
Domain Path: /languages
License: GPLv3
*/


if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action('admin_menu', 'rnn_browser_support_menu');

function rnn_browser_support_menu() {
	add_menu_page('RNN Browser Support', 'Browser Support', 'administrator', __FILE__, 'rnn_browser_support_settings_page', 'dashicons-bell');

	add_action('admin_init', 'register_rnn_browser_support_settings');
}

function register_rnn_browser_support_settings() {
	register_setting('rnn-browser-support-settings-group', 'activate_plugin');
	register_setting('rnn-browser-support-settings-group', 'alert_message');
}

function rnn_browser_support_settings_page() {
	?>
	<div class="wrap">
	<h1>RNN Browser Support</h1>

	<form method="post" action="options.php">
		<?php settings_fields( 'rnn-browser-support-settings-group' ); ?>
		<?php do_settings_sections( 'rnn-browser-support-settings-group' ); ?>
		<table class="form-table">
			<tr valign="top">
			<th scope="row"><?php _e('Enable','rnn-browser-support') ?></th>
			<td><input type="checkbox" name="activate_plugin" value="1" <?php checked(1, get_option('activate_plugin'), true); ?> /></td>
			</tr>
			
			<tr valign="top">
			<th scope="row"><?php _e('Alert Message','rnn-browser-support') ?></th>
			<td><textarea style="width: 400px; height: 100px;" name="alert_message" /><?php echo esc_attr( get_option('alert_message') ); ?></textarea></td>
			</tr>
		</table>
		
		<?php submit_button(); ?>

	</form>
	</div>
	<?
}

function rnn_browser_support_check() {
	$alert_message = trim(preg_replace('/\s\s+/', '\n\n', get_option('alert_message')));
	echo "<script>
				// Check if browser is supported
				var message = '$alert_message';
				if (window.navigator.userAgent.indexOf('Trident/') > 0){
					alert(message);
				}
			</script>";
}

if ( '1' == esc_attr( get_option('activate_plugin') ) ) {
  add_action('wp_footer', 'rnn_browser_support_check');
}

?>