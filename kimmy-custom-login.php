<?php
/**
 * Plugin Name: Kimmy's Custom Login Image and URL
 * Plugin URI: https://github.com/KhineMoeSwe2022/kimmy-login-logo
 * Description: Adds a custom image and URL to the WordPress login screen
 * Version: 1.0
 * Author: Kimmy
 * Tested up to: 6.8
 * It is recommended to use a PHP version of at least 7.4 for security reasons.
 */

if( ! defined('ABSPATH')) exit;

// Add admin menu page
add_action('admin_menu', 'kimmy_login_admin_page');
function kimmy_login_admin_page() {
    add_menu_page(
        'Kimmy Login',
        'Kimmy Login',
        'manage_options',
        'kimmy-logo-settings',
        'kimmy_settings_page',
        'dashicons-admin-customizer',
        99
    );
}

add_action('admin_init', 'kimmy_register_settings');
function kimmy_register_settings() {
    register_setting('kimmy_settings_group', 'kimmy_login_logo');
    register_setting('kimmy_settings_group', 'kimmy_login_url');
}

// write function
function kimmy_settings_page() {
?>
<div class="logo-group">
    <h1>Kimmy Login Logo Settings</h1>
    <form method="post" action="options.php" enctype="multipart/form-data">
        <?php settings_fields('kimmy_settings_group'); ?>
        <?php do_settings_sections('kimmy_settings_group'); ?>

        <table class="form-table">
            <tr>
                <th>Login Logo Image</th>
                <td>
                    <input type="text" name="kimmy_login_logo" value="<?php echo esc_attr(get_option('kimmy_login_logo')); ?>" style="width:60%;" />
                    <p>Pls paste image URL</p>
                </td>
            </tr>
            <tr>
                <th>Login Logo URL</th>
                <td>
                    <input type="text" name="kimmy_login_url" value="<?php echo esc_attr(get_option('kimmy_login_url')); ?>" style="width:60%;" />
                    <p>Pls enter the link URL</p>
                </td>
            </tr>
        </table>

        <?php 
        //core function primarily used within the admin panel to display a submit button
        submit_button(); ?>
    </form>
</div>
<?php
}

//Apply custom logo in WP Dashboard
function my_login_logo() { 
    $login_logo = get_option('kimmy_login_logo');
    if(!$login_logo) return;
?>
    <style type="text/css">
        #login h1 a, .login h1 a {
            background-image: url(<?php echo esc_url($login_logo) ?>);
            height: 60px;
            width: 300px;
            background-size: 300px 60px;
            background-repeat: no-repeat;
            padding-bottom: 10px;
        }
    </style>
<?php }
add_action( 'login_enqueue_scripts', 'my_login_logo' );


// Apply Custom login logo link URL
add_filter( 'login_headerurl', 'custom_loginlogo_url' );
function custom_loginlogo_url( $url ) {
    $login_url = get_option('kimmy_login_url');
    return $login_url ? $login_url : home_url();
}
