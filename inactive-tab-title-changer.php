<?php
/**
 * Plugin Name: Inactive Tab Title Changer
 * Description: Changes the browser tab's title when the tab is inactive.
 * Version: 1.0.0
 * Author: Christoph Lindhauer, f5.design
 * Author URI: https://f5.design
 * License: GPL2
 * Text Domain: inactive-tab-title-changer
 */

defined('ABSPATH') or die('No script kiddies please!');

function ittc_enqueue_scripts() {
    wp_enqueue_script('ittc-main-js', plugins_url('js/main.js', __FILE__), array('jquery'), '1.0.0', true);

    $data = array(
        'inactiveTitle' => get_option('ittc_inactive_title', 'Please come back!'),
        'timeout' => get_option('ittc_timeout', 5000)
    );
    wp_localize_script('ittc-main-js', 'ittcData', $data);
}
add_action('wp_enqueue_scripts', 'ittc_enqueue_scripts');

function ittc_register_settings() {
    add_option('ittc_inactive_title', 'Please come back!');
    add_option('ittc_timeout', '5000');
    register_setting('ittc_options_group', 'ittc_inactive_title', 'strval');
    register_setting('ittc_options_group', 'ittc_timeout', 'intval');
}
add_action('admin_init', 'ittc_register_settings');

function ittc_register_options_page() {
    add_options_page('Inactive Tab Title Changer', 'Inactive Tab Title Changer', 'manage_options', 'ittc', 'ittc_options_page');
}
add_action('admin_menu', 'ittc_register_options_page');

function ittc_options_page() {
    ?>
    <div class="wrap">
        <h2>Inactive Tab Title Changer</h2>
        <form method="post" action="options.php">
            <?php settings_fields('ittc_options_group'); ?>
            <table class="form-table">
                <tr valign="top">
                    <th scope="row"><label for="ittc_inactive_title"><?php _e('Inactive Tab Title', 'inactive-tab-title-changer'); ?></label></th>
                    <td><input type="text" id="ittc_inactive_title" name="ittc_inactive_title" value="<?php echo esc_attr(get_option('ittc_inactive_title')); ?>" /></td>
                </tr>
                <tr valign="top">
                    <th scope="row"><label for="ittc_timeout"><?php _e('Timeout (ms)', 'inactive-tab-title-changer'); ?></label></th>
                    <td><input type="number" id="ittc_timeout" name="ittc_timeout" value="<?php echo esc_attr(get_option('ittc_timeout')); ?>" /></td>
                </tr>
            </table>
            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}

function ittc_load_textdomain() {
    load_plugin_textdomain('inactive-tab-title-changer', false, basename(dirname(__FILE__)) . '/languages');
}
add_action('plugins_loaded', 'ittc_load_textdomain');
?>
