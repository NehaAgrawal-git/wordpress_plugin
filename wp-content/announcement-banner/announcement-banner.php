<?php
/**
 * Plugin Name: Announcement Banner
 * Description: A plugin to add customizable announcement banners to your WordPress site.
 * Version: 1.0
 * Author: Your Name
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// Enqueue scripts and styles
function ab_enqueue_scripts() {
    wp_enqueue_style('ab-style', plugins_url('style.css', __FILE__));
    wp_enqueue_script('ab-script', plugins_url('script.js', __FILE__), array('jquery'), null, true);
}
add_action('wp_enqueue_scripts', 'ab_enqueue_scripts');

// Add banner to the site
function ab_display_banner() {
    $banner_text = get_option('ab_banner_text', 'This is an announcement');
    $banner_link = get_option('ab_banner_link', '#');
    echo '<div id="announcement-banner"><p>' . esc_html($banner_text) . ' <a href="' . esc_url($banner_link) . '">Learn More</a></p></div>';
}
add_action('wp_footer', 'ab_display_banner');

// Create settings menu
function ab_create_menu() {
    add_menu_page('Announcement Banner Settings', 'Announcement Banner', 'manage_options', 'announcement-banner-settings', 'ab_settings_page', '', 200);
}
add_action('admin_menu', 'ab_create_menu');

// Settings page HTML
function ab_settings_page() {
    ?>
    <div class="wrap">
        <h1>Announcement Banner Settings</h1>
        <form method="post" action="options.php">
            <?php settings_fields('ab-settings-group'); ?>
            <?php do_settings_sections('ab-settings-group'); ?>
            <table class="form-table">
                <tr valign="top">
                    <th scope="row">Banner Text</th>
                    <td><input type="text" name="ab_banner_text" value="<?php echo esc_attr(get_option('ab_banner_text')); ?>" /></td>
                </tr>
                <tr valign="top">
                    <th scope="row">Banner Link</th>
                    <td><input type="text" name="ab_banner_link" value="<?php echo esc_attr(get_option('ab_banner_link')); ?>" /></td>
                </tr>
            </table>
            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}

// Register settings
function ab_register_settings() {
    register_setting('ab-settings-group', 'ab_banner_text');
    register_setting('ab-settings-group', 'ab_banner_link');
}
add_action('admin_init', 'ab_register_settings');
?>
