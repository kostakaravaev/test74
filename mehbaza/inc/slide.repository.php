<?php
if (!defined('ABSPATH')) {
  exit;
}

class Mehbaza_Slide_Repository {
  public function all() {
    return get_posts(array(
      'post_type' => MEHBAZA_POST_SLIDE,
      'posts_per_page' => -1,
      'post_status' => 'publish',
      'orderby' => 'menu_order',
      'order' => 'ASC',
    ));
  }
}
