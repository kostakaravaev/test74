<?php
if (!defined('ABSPATH')) {
  exit;
}
$phone = mehbaza_phone();
$email = mehbaza_email();
?>
<section class="section" id="contacts">
  <h2 class="title title_offset_m">База и контакты</h2>
  <div class="contacts">
    <div class="contacts__list">
      <p class="contacts__item">
        <b>Адрес</b><br />
        Москва, Каширское шоссе, д. 65, стр. 2<br />
        въезд со стороны Проектируемого проезда 3664, шлагбаум, сказать «Мехбаза»
      </p>
      <p class="contacts__item">
        <b>Телефон</b><br />
        <a class="contacts__link" href="<?php echo esc_url(mehbaza_phone_href($phone)); ?>"><?php echo esc_html($phone); ?></a> — диспетчер
      </p>
      <p class="contacts__item">
        <b>Почта</b><br />
        <a class="contacts__link" href="mailto:<?php echo esc_attr($email); ?>"><?php echo esc_html($email); ?></a>
      </p>
      <p class="contacts__item">
        <b>Режим</b><br />
        пн–сб 7:00–21:00, вс — дежурный по телефону
      </p>
      <button class="btn contacts__call" type="button" data-toggle="modal" data-target="#callbackModal">
        заказать звонок
      </button>
    </div>
    <div class="map">
      <a class="map__link" href="https://yandex.ru/maps/?pt=37.668,55.643&amp;z=16&amp;l=map" target="_blank" rel="noopener">
        <span class="map__label">Каширское шоссе, 65 стр. 2</span>
        <strong class="map__title">Открыть карту</strong>
      </a>
    </div>
  </div>
</section>
