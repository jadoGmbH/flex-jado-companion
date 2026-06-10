<?php
/**
 * Plugin Name: flex.ja.do Companion
 * Description: Begleit-Plugin für das jadoFlexTheme zur Auslagerung von Plugin-Territorium-Funktionalitäten.
 * Version: 1.0.1
 * Author: jado GmbH
 */

if (!defined('ABSPATH')) {
    exit;
}


function jado_companion_setup_roles() {
    if (!function_exists('get_role')) {
        return;
    }

    $editor = get_role('editor');
    if (!$editor) {
        return;
    }

    $caps = $editor->capabilities;
    $caps['manage_jado_options'] = true;
    $caps['edit_theme_options'] = true;

    if (get_role('admincustomer')) {
        remove_role('admincustomer');
    }
    add_role('admincustomer', __('Admin Customer', 'jadotheme'), $caps);

    // Administrator die Berechtigung geben
    $admin = get_role('administrator');
    if ($admin) {
        $admin->add_cap('manage_jado_options');
    }
}
add_action('init', 'jado_companion_setup_roles');

/**
 * Header Cleanup Funktionalitäten.
 * Ausgelagert aus functions.php
 */
function jado_companion_head_cleanup() {
    remove_action('wp_head', 'rsd_link');
    remove_action('wp_head', 'wlwmanifest_link');
    remove_action('wp_head', 'parent_post_rel_link', 10, 0);
    remove_action('wp_head', 'start_post_rel_link', 10, 0);
    remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
    remove_action('wp_head', 'wp_generator');
}
add_action('init', 'jado_companion_head_cleanup');

/**
 * Ermöglicht SVG-Uploads.
 * Ausgelagert aus lib/theme-settings.php
 */
function jado_companion_enable_svg_uploads() {
    if (function_exists('jado_get_checkbox_state') && jado_get_checkbox_state('enableSVGUploads')) {
        add_filter('upload_mimes', function($mime_types) {
            $mime_types['svg'] = 'image/svg+xml';
            return $mime_types;
        }, 1, 1);
    }
}
add_action('init', 'jado_companion_enable_svg_uploads');

/**
 * Deaktiviert Embeds im Frontend.
 * Ausgelagert aus lib/theme-settings.php
 */
function jado_companion_disable_embeds() {
    if (function_exists('jado_get_checkbox_state') && jado_get_checkbox_state('disableEmbedsFrontend')) {
        remove_action('rest_api_init', 'wp_oembed_register_route');
        add_filter('embed_oembed_discover', '__return_false');
        remove_filter('oembed_dataparse', 'wp_filter_oembed_result', 10);
        remove_action('wp_head', 'wp_oembed_add_discovery_links');
        remove_action('wp_head', 'wp_oembed_add_host_js');
        remove_filter('pre_oembed_result', 'wp_filter_pre_oembed_result', 10);
    }
}
add_action('init', 'jado_companion_disable_embeds', 9999);

/**
 * Email Shortcode zur Verschlüsselung.
 * Ausgelagert aus lib/theme-settings.php
 */
function jado_companion_register_shortcodes() {
    if (function_exists('jado_get_checkbox_state') && jado_get_checkbox_state('encodeEmails')) {
        add_shortcode('email', 'jado_hide_email_shortcode');
    }
}
add_action('init', 'jado_companion_register_shortcodes');

/**
 * Hilfsfunktion für den Email-Shortcode (muss im Theme oder hier definiert sein).
 * Da jado_hide_email_shortcode im Theme definiert ist, lassen wir den Aufruf dort.
 * Falls das Theme nicht aktiv ist, wird add_shortcode nicht ausgeführt oder schlägt fehl.
 */
