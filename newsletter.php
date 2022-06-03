<?php

/**
 * Plugin Name: Newsletter
 * Plugin URI: https://webdev-karin.se
 * Description: Test plugin for newsletter
 * Version: 1.0.0
 * Author: Karin F
 */


// Skapa plugin för newsletter

// * Formulär för att prenumerera
// * hantera formuläret (skickas med ajax?)
// * admin sida, med fält för newsletter API settings
// * admin sida för att lista prenumeranter

if (!defined('WPINC')) {
    die;
}

register_activation_hook(__FILE__, 'plugin_newsletter_activated');
register_deactivation_hook(__FILE__, 'plugin_newsletter_deactivated');

function plugin_newsletter_activated()
{
    register_setting('wcm_newsletter_settings', 'wcm_newsletter_api_key');
    // pluginprefix_setup_post_type();
    // newsletter_fill();
    newsletter_admin_menu();

    flush_rewrite_rules();
}

function plugin_newsletter_deactivated()
{
    register_setting('wcm_newsletter_settings', 'wcm_newsletter_api_key');
    // pluginprefix_setup_post_type();

    flush_rewrite_rules();
}

add_action('admin_menu', 'newsletter_admin_menu');

function newsletter_admin_menu()
{
    add_menu_page(
        'Newsletter',
        'Newsletter',
        'manage_options',
        'wcm_newsletter',
        'wcm_newsletter_admin_menu_page',
        'dashicons-document',
        20,
    );
}


function wcm_newsletter_admin_menu_page()
{
    include plugin_dir_path(__FILE__) . "templates/newsletter_admin_page.php";
}

add_action('admin_init', 'wcm_newsletter_settings_init');
function wcm_newsletter_settings_init()
{
    register_setting('wcm_newsletter_settings', 'wcm_newsletter_api_key');

    add_settings_section(
        'wcm_newsletter_settings_main',
        'wcm newsletter inställningar',
        'wcm_newsletter_settings_sections_html',
        'wcm_newsletter_settings'
    );

    add_settings_field(
        'wcm_newsletter_api_key',
        'API Token',
        'wcm_newsletter_api_field',
        'wcm_newsletter_settings',
        'wcm_newsletter_settings_main'
    );
}

function wcm_newsletter_api_field()
{
    $apiKey = get_option('wcm_newsletter_api_key');

    $output = '<input type="text" name="wcm_newsletter_api_key" value="';
    $output .= isset($apiKey) ? $apiKey : '';
    $output .= '"/>';

    echo $output;
}

function wcm_newsletter_settings_sections_html()
{
    echo '<p>inställningar</p>';
}

add_shortcode('newsletter_form', 'my_newsletter_form');

function my_newsletter_form($atts = [], $content = null)
{
    ob_start();
    include(plugin_dir_path(__FILE__) . 'templates/newsletter_form.php');
    return ob_get_clean();
}

add_action('wp_ajax_my_newsletter_ajax_action', 'handle_my_newsletter');
add_action('wp_ajax_nopriv_my_newsletter_ajax_action', 'handle_my_newsletter'); //ändelsen på vår add_action kommer från vårt value i vår hidden input i formuläret där name=action, då kan wp fånga upp vår action på det sättet.

function handle_my_newsletter()
{
    if (!wp_verify_nonce($_POST['nonce'], "newsletter_nonce")) {
        exit(var_dump($_POST));
    }

    // $args = [
    //     'headers' => [
    //         'Content-Type'  => 'application/json',
    //         'Autorization' => 'Token ' . get_option('wcm_newsletter_api_key'),
    //     ],
    //     'body' => json_encode([
    //         'email' => $_POST['email'],
    //         'lists' => [
    //             ['hash' => 'uw89hs6Y8l2aOC1rq'],
    //         ],
    //     ])
    // ];

    // $apiUrl   =  "https://api.getanewsletter.com/v3/contacts/";

    // $response = wp_remote_post($apiUrl, $args);

    // wp_send_json($response);

    // var_dump(json_decode(wp_remote_retrieve_body($response)));
}

add_action('init', 'newsletter_scripts');
function newsletter_scripts()
{
    wp_register_script(
        'newsletter_plugin_script',
        plugins_url(
            '/js/wcm_newsletter.js',
            __FILE__,
            [],
            '0.0.1',
            true
        )
    );

    wp_enqueue_script('newsletter_plugin_script');
}
