<?php
if (!defined('ABSPATH')) {
  exit;
}

class Mehbaza_Lead_Controller {
  public function submit() {
    $nonce = isset($_POST['nonce']) ? sanitize_text_field(wp_unslash($_POST['nonce'])) : '';
    if (!wp_verify_nonce($nonce, MEHBAZA_NONCE_LEAD)) {
      wp_send_json_error(array('message' => MEHBAZA_MSG_FAIL), 403);
    }

    $payload = array(
      'name' => isset($_POST['name']) ? sanitize_text_field(wp_unslash($_POST['name'])) : '',
      'phone' => isset($_POST['phone']) ? sanitize_text_field(wp_unslash($_POST['phone'])) : '',
      'equipment' => isset($_POST['equipment']) ? sanitize_text_field(wp_unslash($_POST['equipment'])) : '',
      'comment' => isset($_POST['comment']) ? sanitize_textarea_field(wp_unslash($_POST['comment'])) : '',
      'agree' => !empty($_POST['agree']),
    );

    $service = new Mehbaza_Lead_Service();
    $result = $service->submit($payload);

    if ($result['ok']) {
      wp_send_json_success(array('message' => $result['message']));
    }

    wp_send_json_error(array('message' => $result['message']));
  }
}

function mehbaza_lead_controller_submit() {
  $controller = new Mehbaza_Lead_Controller();
  $controller->submit();
}
