<?php
if (!defined('ABSPATH')) {
  exit;
}

function mehbaza_header_settings_page_id() {
  return (int) get_option(MEHBAZA_HEADER_PAGE_OPTION);
}

function mehbaza_ensure_header_settings_page() {
  $page_id = mehbaza_header_settings_page_id();
  if ($page_id > 0 && get_post_status($page_id)) {
    return $page_id;
  }

  $page_id = wp_insert_post(array(
    'post_type' => 'page',
    'post_status' => 'publish',
    'post_title' => MEHBAZA_HEADER_PAGE_TITLE,
    'post_name' => MEHBAZA_HEADER_PAGE_SLUG,
    'post_content' => '',
  ));

  if (is_wp_error($page_id) || !$page_id) {
    return 0;
  }

  update_option(MEHBAZA_HEADER_PAGE_OPTION, (int) $page_id);
  return (int) $page_id;
}

function mehbaza_prefill_header_fields($page_id) {
  if ($page_id < 1 || !function_exists('update_field')) {
    return;
  }

  $defaults = array(
    MEHBAZA_FIELD_PHONE => MEHBAZA_PHONE_DEFAULT,
    MEHBAZA_FIELD_NOTE => MEHBAZA_NOTE_DEFAULT,
    MEHBAZA_FIELD_EMAIL => MEHBAZA_EMAIL_DEFAULT,
  );

  foreach ($defaults as $name => $default) {
    $current = get_field($name, $page_id);
    if ($current === '' || $current === null || $current === false) {
      update_field($name, $default, $page_id);
    }
  }
}

function mehbaza_hide_header_settings_page() {
  $page_id = mehbaza_header_settings_page_id();
  if ($page_id > 0 && is_page($page_id)) {
    wp_safe_redirect(home_url('/'));
    exit;
  }
}

function mehbaza_register_header_admin_menu() {
  add_menu_page(
    MEHBAZA_HEADER_PAGE_TITLE,
    MEHBAZA_HEADER_PAGE_TITLE,
    'edit_pages',
    MEHBAZA_HEADER_MENU_SLUG,
    'mehbaza_header_admin_redirect',
    'dashicons-phone',
    58
  );
}

function mehbaza_header_admin_redirect() {
  return;
}

function mehbaza_header_admin_maybe_redirect() {
  if (!is_admin() || !isset($_GET['page']) || $_GET['page'] !== MEHBAZA_HEADER_MENU_SLUG) {
    return;
  }

  $page_id = mehbaza_ensure_header_settings_page();
  if ($page_id < 1) {
    return;
  }

  mehbaza_prefill_header_fields($page_id);
  wp_safe_redirect(admin_url('post.php?post=' . $page_id . '&action=edit'));
  exit;
}

function mehbaza_register_options_page() {
  if (!function_exists('acf_add_options_page')) {
    return;
  }

  acf_add_options_page(array(
    'page_title' => 'Шапка сайта',
    'menu_title' => 'Шапка сайта',
    'menu_slug' => MEHBAZA_OPTIONS_PAGE,
    'capability' => 'edit_theme_options',
    'redirect' => false,
  ));
}

function mehbaza_register_acf_fields() {
  if (!function_exists('acf_add_local_field_group')) {
    return;
  }

  $header_location = array(
    array(
      array(
        'param' => 'page_type',
        'operator' => '==',
        'value' => 'front_page',
      ),
    ),
  );

  $header_page_id = mehbaza_ensure_header_settings_page();
  if ($header_page_id > 0) {
    $header_location[] = array(
      array(
        'param' => 'page',
        'operator' => '==',
        'value' => (string) $header_page_id,
      ),
    );
    mehbaza_prefill_header_fields($header_page_id);
  }

  if (function_exists('acf_add_options_page')) {
    $header_location[] = array(
      array(
        'param' => 'options_page',
        'operator' => '==',
        'value' => MEHBAZA_OPTIONS_PAGE,
      ),
    );
  }

  acf_add_local_field_group(array(
    'key' => 'group_mehbaza_header',
    'title' => 'Шапка',
    'fields' => array(
      array(
        'key' => 'field_mehbaza_phone',
        'label' => 'Телефон',
        'name' => MEHBAZA_FIELD_PHONE,
        'type' => 'text',
        'default_value' => MEHBAZA_PHONE_DEFAULT,
      ),
      array(
        'key' => 'field_mehbaza_note',
        'label' => 'Текст справа в шапке',
        'name' => MEHBAZA_FIELD_NOTE,
        'type' => 'text',
        'default_value' => MEHBAZA_NOTE_DEFAULT,
      ),
      array(
        'key' => 'field_mehbaza_email',
        'label' => 'Почта',
        'name' => MEHBAZA_FIELD_EMAIL,
        'type' => 'email',
        'default_value' => MEHBAZA_EMAIL_DEFAULT,
      ),
    ),
    'location' => $header_location,
  ));

  acf_add_local_field_group(array(
    'key' => 'group_mehbaza_slide',
    'title' => 'Слайд',
    'fields' => array(
      array(
        'key' => 'field_mehbaza_kicker',
        'label' => 'Над заголовком',
        'name' => MEHBAZA_FIELD_KICKER,
        'type' => 'text',
      ),
      array(
        'key' => 'field_mehbaza_slide_title',
        'label' => 'Заголовок на слайде',
        'name' => MEHBAZA_FIELD_SLIDE_TITLE,
        'type' => 'text',
      ),
      array(
        'key' => 'field_mehbaza_slide_price',
        'label' => 'Текст под заголовком',
        'name' => MEHBAZA_FIELD_SLIDE_PRICE,
        'type' => 'text',
      ),
      array(
        'key' => 'field_mehbaza_slide_link',
        'label' => 'Ссылка кнопки «подробнее»',
        'name' => MEHBAZA_FIELD_SLIDE_LINK,
        'type' => 'text',
      ),
    ),
    'location' => array(
      array(
        array(
          'param' => 'post_type',
          'operator' => '==',
          'value' => MEHBAZA_POST_SLIDE,
        ),
      ),
    ),
  ));

  acf_add_local_field_group(array(
    'key' => 'group_mehbaza_equipment',
    'title' => 'Карточка техники',
    'fields' => array(
      array(
        'key' => 'field_mehbaza_eq_price',
        'label' => 'Цена',
        'name' => MEHBAZA_FIELD_EQ_PRICE,
        'type' => 'text',
      ),
      array(
        'key' => 'field_mehbaza_eq_spec',
        'label' => 'Характеристики',
        'name' => MEHBAZA_FIELD_EQ_SPEC,
        'type' => 'text',
      ),
      array(
        'key' => 'field_mehbaza_eq_badge',
        'label' => 'Плашка на фото',
        'name' => MEHBAZA_FIELD_EQ_BADGE,
        'type' => 'text',
      ),
    ),
    'location' => array(
      array(
        array(
          'param' => 'post_type',
          'operator' => '==',
          'value' => MEHBAZA_POST_EQUIPMENT,
        ),
      ),
    ),
  ));
}
