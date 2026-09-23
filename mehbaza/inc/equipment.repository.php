<?php
if (!defined('ABSPATH')) {
  exit;
}

class Mehbaza_Equipment_Repository {
  public function all() {
    return get_posts(array(
      'post_type' => MEHBAZA_POST_EQUIPMENT,
      'posts_per_page' => -1,
      'post_status' => 'publish',
      'orderby' => 'menu_order',
      'order' => 'ASC',
    ));
  }

  public function titles() {
    $titles = array();
    foreach ($this->all() as $item) {
      $titles[] = get_the_title($item);
    }
    return $titles;
  }

  public function category_slug($post_id) {
    $terms = get_the_terms($post_id, MEHBAZA_TAX_EQUIPMENT);
    if (empty($terms) || is_wp_error($terms)) {
      return MEHBAZA_CAT_EARTH;
    }
    return $terms[0]->slug;
  }

  public function categories() {
    $terms = get_terms(array(
      'taxonomy' => MEHBAZA_TAX_EQUIPMENT,
      'hide_empty' => false,
    ));
    return is_wp_error($terms) ? array() : $terms;
  }
}
