<?php
if (!defined('ABSPATH')) {
  exit;
}

require_once get_template_directory() . '/inc/mehbaza.constants.php';
require_once get_template_directory() . '/inc/helpers.php';
require_once get_template_directory() . '/inc/slide.repository.php';
require_once get_template_directory() . '/inc/equipment.repository.php';
require_once get_template_directory() . '/inc/lead.repository.php';
require_once get_template_directory() . '/inc/lead.service.php';
require_once get_template_directory() . '/inc/lead.controller.php';
require_once get_template_directory() . '/inc/lead.admin.php';
require_once get_template_directory() . '/inc/cpt.php';
require_once get_template_directory() . '/inc/acf-fields.php';
require_once get_template_directory() . '/inc/setup.php';
require_once get_template_directory() . '/inc/demo-content.php';

add_action('after_setup_theme', 'mehbaza_setup');
add_action('init', 'mehbaza_register_post_types');
add_action('acf/init', 'mehbaza_register_options_page');
add_action('acf/init', 'mehbaza_register_acf_fields');
add_action('admin_menu', 'mehbaza_register_header_admin_menu');
add_action('admin_init', 'mehbaza_header_admin_maybe_redirect');
add_action('template_redirect', 'mehbaza_hide_header_settings_page');
add_action('wp_enqueue_scripts', 'mehbaza_enqueue_assets');
add_action('admin_notices', 'mehbaza_acf_notice');
add_action('after_switch_theme', 'mehbaza_seed_demo');
add_action('wp_ajax_' . MEHBAZA_AJAX_LEAD, 'mehbaza_lead_controller_submit');
add_action('wp_ajax_nopriv_' . MEHBAZA_AJAX_LEAD, 'mehbaza_lead_controller_submit');
