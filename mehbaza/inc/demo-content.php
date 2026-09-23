<?php
if (!defined('ABSPATH')) {
  exit;
}

function mehbaza_sideload_image($filename, $post_id) {
  $source = get_template_directory() . '/assets/img/' . $filename;
  if (!file_exists($source)) {
    return 0;
  }

  require_once ABSPATH . 'wp-admin/includes/file.php';
  require_once ABSPATH . 'wp-admin/includes/media.php';
  require_once ABSPATH . 'wp-admin/includes/image.php';

  $tmp = wp_tempnam($filename);
  copy($source, $tmp);

  $file_array = array(
    'name' => $filename,
    'tmp_name' => $tmp,
  );

  $id = media_handle_sideload($file_array, $post_id);
  if (is_wp_error($id)) {
    @unlink($tmp);
    return 0;
  }

  return (int) $id;
}

function mehbaza_insert_term($name, $slug) {
  $existing = get_term_by('slug', $slug, MEHBAZA_TAX_EQUIPMENT);
  if ($existing && !is_wp_error($existing)) {
    return (int) $existing->term_id;
  }
  $result = wp_insert_term($name, MEHBAZA_TAX_EQUIPMENT, array('slug' => $slug));
  if (is_wp_error($result)) {
    return 0;
  }
  return (int) $result['term_id'];
}

function mehbaza_create_slide($order, $title, $kicker, $price, $link, $image) {
  $id = wp_insert_post(array(
    'post_type' => MEHBAZA_POST_SLIDE,
    'post_status' => 'publish',
    'post_title' => $title,
    'menu_order' => $order,
  ));
  if (!$id || is_wp_error($id)) {
    return;
  }
  if (function_exists('update_field')) {
    update_field(MEHBAZA_FIELD_KICKER, $kicker, $id);
    update_field(MEHBAZA_FIELD_SLIDE_TITLE, $title, $id);
    update_field(MEHBAZA_FIELD_SLIDE_PRICE, $price, $id);
    update_field(MEHBAZA_FIELD_SLIDE_LINK, $link, $id);
  } else {
    update_post_meta($id, MEHBAZA_FIELD_KICKER, $kicker);
    update_post_meta($id, MEHBAZA_FIELD_SLIDE_TITLE, $title);
    update_post_meta($id, MEHBAZA_FIELD_SLIDE_PRICE, $price);
    update_post_meta($id, MEHBAZA_FIELD_SLIDE_LINK, $link);
  }
  $thumb = mehbaza_sideload_image($image, $id);
  if ($thumb > 0) {
    set_post_thumbnail($id, $thumb);
  }
}

function mehbaza_create_equipment($order, $title, $price, $spec, $badge, $cat, $image) {
  $id = wp_insert_post(array(
    'post_type' => MEHBAZA_POST_EQUIPMENT,
    'post_status' => 'publish',
    'post_title' => $title,
    'menu_order' => $order,
  ));
  if (!$id || is_wp_error($id)) {
    return;
  }
  if (function_exists('update_field')) {
    update_field(MEHBAZA_FIELD_EQ_PRICE, $price, $id);
    update_field(MEHBAZA_FIELD_EQ_SPEC, $spec, $id);
    update_field(MEHBAZA_FIELD_EQ_BADGE, $badge, $id);
  } else {
    update_post_meta($id, MEHBAZA_FIELD_EQ_PRICE, $price);
    update_post_meta($id, MEHBAZA_FIELD_EQ_SPEC, $spec);
    update_post_meta($id, MEHBAZA_FIELD_EQ_BADGE, $badge);
  }
  wp_set_object_terms($id, $cat, MEHBAZA_TAX_EQUIPMENT);
  $thumb = mehbaza_sideload_image($image, $id);
  if ($thumb > 0) {
    set_post_thumbnail($id, $thumb);
  }
}

function mehbaza_seed_demo() {
  if (get_option(MEHBAZA_DEMO_FLAG)) {
    return;
  }

  mehbaza_register_post_types();

  $earth = mehbaza_insert_term('земляные', MEHBAZA_CAT_EARTH);
  $lift = mehbaza_insert_term('подъём', MEHBAZA_CAT_LIFT);
  $haul = mehbaza_insert_term('перевозка', MEHBAZA_CAT_HAUL);
  unset($earth, $lift, $haul);

  $home_id = wp_insert_post(array(
    'post_type' => 'page',
    'post_status' => 'publish',
    'post_title' => 'Главная',
    'post_name' => 'home',
  ));
  if ($home_id && !is_wp_error($home_id)) {
    update_option('show_on_front', 'page');
    update_option('page_on_front', $home_id);
    if (function_exists('update_field')) {
      update_field(MEHBAZA_FIELD_PHONE, MEHBAZA_PHONE_DEFAULT, $home_id);
      update_field(MEHBAZA_FIELD_NOTE, MEHBAZA_NOTE_DEFAULT, $home_id);
      update_field(MEHBAZA_FIELD_EMAIL, MEHBAZA_EMAIL_DEFAULT, $home_id);
      if (function_exists('acf_add_options_page')) {
        update_field(MEHBAZA_FIELD_PHONE, MEHBAZA_PHONE_DEFAULT, 'option');
        update_field(MEHBAZA_FIELD_NOTE, MEHBAZA_NOTE_DEFAULT, 'option');
        update_field(MEHBAZA_FIELD_EMAIL, MEHBAZA_EMAIL_DEFAULT, 'option');
      }
    }
  }

  $park_url = home_url('/#park');
  mehbaza_create_slide(1, 'Гусеничный экскаватор', 'Котлован, траншеи, планировка', 'от 18 500 ₽ / смена · машинист в цене', $park_url, 'hero-excavator.jpg');
  mehbaza_create_slide(2, 'Автокран 25–70 тонн', 'Монтаж, плиты, оборудование', 'от 22 000 ₽ / смена · стрела до 40 м', $park_url, 'hero-crane.jpg');
  mehbaza_create_slide(3, 'Самосвал 15–20 м³', 'Вывоз грунта, щебень, песок', 'от 14 500 ₽ / смена · по Москве и области', $park_url, 'hero-dump.jpg');

  mehbaza_create_equipment(1, 'Doosan DX225', '18 500 ₽', 'ковш 1,2 м³ · гусеницы · машинист', 'свободна на завтра', MEHBAZA_CAT_EARTH, 'fleet-doosan.jpg');
  mehbaza_create_equipment(2, 'Hyundai R220LC', '21 000 ₽', 'ковш 1,1 м³ · для плотного грунта', '', MEHBAZA_CAT_EARTH, 'fleet-hyundai.jpg');
  mehbaza_create_equipment(3, 'JCB 3CX', '16 000 ₽', 'экскаватор-погрузчик · узкий двор, коммуникации', '', MEHBAZA_CAT_EARTH, 'fleet-jcb.jpg');
  mehbaza_create_equipment(4, 'Погрузчик 544K', '17 000 ₽', 'ковш 2,3 м³ · щебень, снег, планировка', '', MEHBAZA_CAT_EARTH, 'fleet-loader.jpg');
  mehbaza_create_equipment(5, 'Автокран 32 т', '28 000 ₽', 'стрела 40 м · монтаж плит и оборудования', '', MEHBAZA_CAT_LIFT, 'fleet-crane.jpg');
  mehbaza_create_equipment(6, 'Автовышка АГП-18', '9 800 ₽', 'корзина 200 кг · фасады, освещение, деревья', 'две машины на линии', MEHBAZA_CAT_LIFT, 'fleet-lift.jpg');
  mehbaza_create_equipment(7, 'КамАЗ 20 м³', '14 500 ₽', 'грунт, песок, щебень · можно звеном из трёх', '', MEHBAZA_CAT_HAUL, 'fleet-dump.jpg');
  mehbaza_create_equipment(8, 'Бульдозер CAT D6', '24 000 ₽', 'планировка площадки · отвал 3,4 м', '', MEHBAZA_CAT_EARTH, 'fleet-bulldozer.jpg');

  $menu_id = wp_create_nav_menu('Верхнее меню');
  if (!is_wp_error($menu_id)) {
    $items = array(
      'о компании' => home_url('/#about'),
      'парк' => home_url('/#park'),
      'отзывы' => home_url('/#reviews'),
      'контакты' => home_url('/#contacts'),
    );
    $position = 1;
    foreach ($items as $label => $url) {
      wp_update_nav_menu_item($menu_id, 0, array(
        'menu-item-title' => $label,
        'menu-item-url' => $url,
        'menu-item-status' => 'publish',
        'menu-item-type' => 'custom',
        'menu-item-position' => $position,
      ));
      $position++;
    }
    $locations = get_theme_mod('nav_menu_locations', array());
    $locations[MEHBAZA_MENU_HEADER] = $menu_id;
    set_theme_mod('nav_menu_locations', $locations);
  }

  update_option(MEHBAZA_DEMO_FLAG, 1);
}
