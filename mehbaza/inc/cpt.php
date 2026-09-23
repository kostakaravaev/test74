<?php
if (!defined('ABSPATH')) {
  exit;
}

function mehbaza_register_post_types() {
  register_post_type(MEHBAZA_POST_SLIDE, array(
    'labels' => array(
      'name' => 'Слайдер',
      'singular_name' => 'Слайд',
      'add_new' => 'Добавить слайд',
      'add_new_item' => 'Новый слайд',
      'edit_item' => 'Редактировать слайд',
      'menu_name' => 'Слайдер',
    ),
    'public' => false,
    'show_ui' => true,
    'show_in_menu' => true,
    'menu_icon' => 'dashicons-images-alt2',
    'supports' => array('title', 'thumbnail', 'page-attributes'),
  ));

  register_post_type(MEHBAZA_POST_EQUIPMENT, array(
    'labels' => array(
      'name' => 'Парк техники',
      'singular_name' => 'Техника',
      'add_new' => 'Добавить технику',
      'add_new_item' => 'Новая единица',
      'edit_item' => 'Редактировать технику',
      'menu_name' => 'Парк техники',
    ),
    'public' => false,
    'show_ui' => true,
    'show_in_menu' => true,
    'menu_icon' => 'dashicons-car',
    'supports' => array('title', 'thumbnail', 'page-attributes'),
  ));

  register_taxonomy(MEHBAZA_TAX_EQUIPMENT, MEHBAZA_POST_EQUIPMENT, array(
    'labels' => array(
      'name' => 'Категории техники',
      'singular_name' => 'Категория',
    ),
    'public' => false,
    'show_ui' => true,
    'hierarchical' => true,
    'show_admin_column' => true,
  ));

  register_post_type(MEHBAZA_POST_LEAD, array(
    'labels' => array(
      'name' => 'Заявки',
      'singular_name' => 'Заявка',
      'menu_name' => 'Заявки',
    ),
    'public' => false,
    'show_ui' => true,
    'show_in_menu' => true,
    'menu_icon' => 'dashicons-email-alt',
    'supports' => array('title'),
    'capability_type' => 'post',
    'map_meta_cap' => true,
    'capabilities' => array(
      'create_posts' => 'do_not_allow',
    ),
  ));
}

function mehbaza_lead_columns($columns) {
  return array(
    'cb' => $columns['cb'],
    'title' => 'Имя',
    'lead_phone' => 'Телефон',
    'lead_equipment' => 'Техника',
    'lead_comment' => 'Комментарий',
    'date' => 'Дата',
  );
}

function mehbaza_lead_column_value($column, $post_id) {
  $map = array(
    'lead_phone' => MEHBAZA_META_PHONE,
    'lead_equipment' => MEHBAZA_META_EQUIPMENT,
    'lead_comment' => MEHBAZA_META_COMMENT,
  );
  if (!isset($map[$column])) {
    return;
  }
  echo esc_html((string) get_post_meta($post_id, $map[$column], true));
}

add_filter('manage_' . MEHBAZA_POST_LEAD . '_posts_columns', 'mehbaza_lead_columns');
add_action('manage_' . MEHBAZA_POST_LEAD . '_posts_custom_column', 'mehbaza_lead_column_value', 10, 2);
