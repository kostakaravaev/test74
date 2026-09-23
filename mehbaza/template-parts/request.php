<?php
if (!defined('ABSPATH')) {
  exit;
}
?>
<section class="section section_theme_paper" id="request">
  <div class="request">
    <div class="request__info">
      <h2 class="title">Оставить заявку</h2>
      <p class="lead lead_offset_top">
        Напишите телефон и что нужно на объект. Если не знаете модель — опишите задачу:
        «котлован 40 на 20, глубина 3». Диспетчер подберёт сам.
      </p>
      <p class="form__note">
        Пн–сб с 7:00 до 21:00. В воскресенье дежурный берёт трубку, выезд — если техника
        уже в городе.
      </p>
    </div>
    <?php get_template_part('template-parts/form', null, array('agree_id' => 'agreeMain', 'submit_label' => 'отправить заявку')); ?>
  </div>
</section>
