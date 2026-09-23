<?php
if (!defined('ABSPATH')) {
  exit;
}

function mehbaza_setup() {
  add_theme_support('title-tag');
  add_theme_support('post-thumbnails');
  add_theme_support('html5', array('search-form', 'comment-form', 'gallery', 'caption'));

  register_nav_menus(array(
    MEHBAZA_MENU_HEADER => 'Верхнее меню',
  ));
}

function mehbaza_enqueue_assets() {
  $uri = get_template_directory_uri();
  $dir = get_template_directory();

  wp_enqueue_style(
    'mehbaza-fonts',
    $uri . '/assets/css/fonts.css',
    array(),
    filemtime($dir . '/assets/css/fonts.css')
  );
  wp_enqueue_style(
    'mehbaza-bootstrap',
    $uri . '/assets/css/bootstrap.min.css',
    array(),
    filemtime($dir . '/assets/css/bootstrap.min.css')
  );
  wp_enqueue_style(
    'mehbaza-style',
    $uri . '/assets/css/style.css',
    array('mehbaza-bootstrap'),
    filemtime($dir . '/assets/css/style.css')
  );
  wp_enqueue_style(
    'mehbaza-media',
    $uri . '/assets/css/media.css',
    array('mehbaza-style'),
    filemtime($dir . '/assets/css/media.css')
  );

  wp_enqueue_script('jquery');
  wp_enqueue_script(
    'mehbaza-bootstrap',
    $uri . '/assets/js/bootstrap.bundle.min.js',
    array('jquery'),
    filemtime($dir . '/assets/js/bootstrap.bundle.min.js'),
    true
  );
  wp_enqueue_script(
    'mehbaza-script',
    $uri . '/assets/js/script.js',
    array('jquery', 'mehbaza-bootstrap'),
    filemtime($dir . '/assets/js/script.js'),
    true
  );

  $equipment = new Mehbaza_Equipment_Repository();
  wp_localize_script('mehbaza-script', 'MehbazaData', array(
    'ajaxUrl' => admin_url('admin-ajax.php'),
    'action' => MEHBAZA_AJAX_LEAD,
    'nonce' => wp_create_nonce(MEHBAZA_NONCE_LEAD),
    'equipment' => $equipment->titles(),
    'filterAll' => MEHBAZA_FILTER_ALL,
    'parkId' => 'park',
    'desktopMin' => MEHBAZA_DESKTOP_MIN,
    'phoneDigits' => MEHBAZA_PHONE_DIGITS,
    'nameMin' => MEHBAZA_NAME_MIN,
    'msgOk' => MEHBAZA_MSG_OK,
    'msgPhone' => MEHBAZA_MSG_PHONE,
    'msgName' => MEHBAZA_MSG_NAME,
    'msgAgree' => MEHBAZA_MSG_AGREE,
    'msgFail' => MEHBAZA_MSG_FAIL,
  ));
}

function mehbaza_acf_notice() {
  if (function_exists('acf_add_local_field_group')) {
    return;
  }
  echo '<div class="notice notice-warning"><p>Для темы «Мехбаза» установите плагин <strong>Advanced Custom Fields</strong>: телефон и текст шапки, слайды и карточки техники.</p></div>';
}
