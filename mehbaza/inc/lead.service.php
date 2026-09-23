<?php
if (!defined('ABSPATH')) {
  exit;
}

class Mehbaza_Lead_Service {
  private $repository;

  public function __construct() {
    $this->repository = new Mehbaza_Lead_Repository();
  }

  public function submit($payload) {
    $error = $this->validate($payload);
    if ($error !== '') {
      return array(
        'ok' => false,
        'message' => $error,
      );
    }

    $id = $this->repository->create(array(
      'name' => $payload['name'],
      'phone' => $payload['phone'],
      'equipment' => $payload['equipment'],
      'comment' => $payload['comment'],
    ));

    if ($id < 1) {
      return array(
        'ok' => false,
        'message' => MEHBAZA_MSG_FAIL,
      );
    }

    return array(
      'ok' => true,
      'message' => MEHBAZA_MSG_OK,
    );
  }

  private function validate($payload) {
    if (mb_strlen($payload['name']) < MEHBAZA_NAME_MIN) {
      return MEHBAZA_MSG_NAME;
    }
    if (strlen(mehbaza_digits($payload['phone'])) !== MEHBAZA_PHONE_DIGITS) {
      return MEHBAZA_MSG_PHONE;
    }
    if (empty($payload['agree'])) {
      return MEHBAZA_MSG_AGREE;
    }
    return '';
  }
}
