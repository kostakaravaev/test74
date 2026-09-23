<?php
if (!defined('ABSPATH')) {
  exit;
}

$agree_id = isset($args['agree_id']) ? $args['agree_id'] : 'agreeMain';
$submit_label = isset($args['submit_label']) ? $args['submit_label'] : 'отправить заявку';
$equipment = (new Mehbaza_Equipment_Repository())->titles();
?>
<form class="form js-lead-form" novalidate>
  <div class="form__ok js-form-ok"></div>
  <div class="form__err js-form-err"></div>
  <div class="form__group">
    <input class="form__control form-control" type="text" name="name" placeholder="Имя" autocomplete="name" />
  </div>
  <div class="form__group">
    <input class="form__control form-control" type="tel" name="phone" placeholder="+7 (___) ___-__-__" autocomplete="tel" />
  </div>
  <div class="form__group">
    <select class="form__select custom-select" name="equipment">
      <option value="">Техника / задача</option>
      <?php foreach ($equipment as $name) : ?>
        <option value="<?php echo esc_attr($name); ?>"><?php echo esc_html($name); ?></option>
      <?php endforeach; ?>
      <option value="Пока не знаю, опишу задачу">Пока не знаю, опишу задачу</option>
    </select>
  </div>
  <div class="form__group">
    <textarea class="form__control form__control_area form-control" name="comment" placeholder="Адрес объекта, сроки, что копать / поднимать"></textarea>
  </div>
  <div class="form__group form-check">
    <input class="form-check-input" type="checkbox" name="agree" id="<?php echo esc_attr($agree_id); ?>" />
    <label class="form__agree form-check-label" for="<?php echo esc_attr($agree_id); ?>">
      Согласен на обработку персональных данных
    </label>
  </div>
  <button class="btn<?php echo $agree_id === 'agreeMain' ? ' btn_wide' : ''; ?> js-submit" type="submit">
    <?php echo esc_html($submit_label); ?>
  </button>
</form>
