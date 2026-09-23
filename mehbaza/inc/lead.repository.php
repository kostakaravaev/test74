<?php
if (!defined('ABSPATH')) {
  exit;
}

class Mehbaza_Lead_Repository {
  public function create($data) {
    $title = $data['name'] . MEHBAZA_LEAD_TITLE_SEP . $data['phone'];
    $post_id = wp_insert_post(array(
      'post_type' => MEHBAZA_POST_LEAD,
      'post_status' => 'publish',
      'post_title' => wp_strip_all_tags($title),
      'post_content' => $data['comment'],
    ), true);

    if (is_wp_error($post_id) || !$post_id) {
      return 0;
    }

    update_post_meta($post_id, MEHBAZA_META_NAME, $data['name']);
    update_post_meta($post_id, MEHBAZA_META_PHONE, $data['phone']);
    update_post_meta($post_id, MEHBAZA_META_EQUIPMENT, $data['equipment']);
    update_post_meta($post_id, MEHBAZA_META_COMMENT, $data['comment']);
    update_post_meta($post_id, MEHBAZA_META_AGREE, 1);

    return (int) $post_id;
  }

  public function find($post_id) {
    $post = get_post($post_id);
    if (!$post) {
      return array();
    }

    $name = (string) get_post_meta($post_id, MEHBAZA_META_NAME, true);
    if ($name === '' && strpos($post->post_title, MEHBAZA_LEAD_TITLE_SEP) !== false) {
      $name = trim(explode(MEHBAZA_LEAD_TITLE_SEP, $post->post_title, 2)[0]);
    }

    $comment = (string) get_post_meta($post_id, MEHBAZA_META_COMMENT, true);
    if ($comment === '') {
      $comment = $post->post_content;
    }

    return array(
      'name' => $name !== '' ? $name : $post->post_title,
      'phone' => (string) get_post_meta($post_id, MEHBAZA_META_PHONE, true),
      'equipment' => (string) get_post_meta($post_id, MEHBAZA_META_EQUIPMENT, true),
      'comment' => $comment,
    );
  }
}
