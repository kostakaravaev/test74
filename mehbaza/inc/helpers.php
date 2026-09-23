<?php
if (!defined('ABSPATH')) {
  exit;
}

function mehbaza_acf_value($name, $default = '') {
  if (!function_exists('get_field')) {
    return $default;
  }

  $value = '';
  if (function_exists('acf_add_options_page')) {
    $value = get_field($name, 'option');
  }

  if (!$value) {
    $front_id = (int) get_option('page_on_front');
    if ($front_id > 0) {
      $value = get_field($name, $front_id);
    }
  }

  if (!$value) {
    $header_id = mehbaza_header_settings_page_id();
    if ($header_id > 0) {
      $value = get_field($name, $header_id);
    }
  }

  if (is_string($value)) {
    $value = trim($value);
  }

  return $value !== '' && $value !== null && $value !== false ? $value : $default;
}

function mehbaza_phone() {
  return mehbaza_acf_value(MEHBAZA_FIELD_PHONE, MEHBAZA_PHONE_DEFAULT);
}

function mehbaza_header_note() {
  return mehbaza_acf_value(MEHBAZA_FIELD_NOTE, MEHBAZA_NOTE_DEFAULT);
}

function mehbaza_email() {
  return mehbaza_acf_value(MEHBAZA_FIELD_EMAIL, MEHBAZA_EMAIL_DEFAULT);
}

function mehbaza_phone_href($phone = '') {
  $digits = preg_replace('/\D+/', '', $phone !== '' ? $phone : mehbaza_phone());
  if ($digits === '') {
    return 'tel:' . MEHBAZA_TEL_DEFAULT;
  }
  if (strpos($digits, '8') === 0) {
    $digits = '7' . substr($digits, 1);
  }
  if (strpos($digits, '7') !== 0) {
    $digits = '7' . $digits;
  }
  return 'tel:+' . $digits;
}

function mehbaza_post_field($name, $post_id, $default = '') {
  $value = '';
  if (function_exists('get_field')) {
    $value = get_field($name, $post_id);
  }
  if ($value === '' || $value === null || $value === false) {
    $value = get_post_meta($post_id, $name, true);
  }
  return $value !== '' && $value !== null && $value !== false ? $value : $default;
}

function mehbaza_digits($value) {
  return preg_replace('/\D+/', '', (string) $value);
}
