<?php
if (!defined('ABSPATH')) {
  exit;
}

$repository = new Mehbaza_Equipment_Repository();
$items = $repository->all();
?>
<section class="section" id="park">
  <div class="section__head">
    <h2 class="title">Парк техники</h2>
    <div class="filters">
      <button class="filters__item js-filter filters__item_active" type="button" data-type="<?php echo esc_attr(MEHBAZA_FILTER_ALL); ?>">все</button>
      <button class="filters__item js-filter" type="button" data-type="<?php echo esc_attr(MEHBAZA_CAT_EARTH); ?>">земляные</button>
      <button class="filters__item js-filter" type="button" data-type="<?php echo esc_attr(MEHBAZA_CAT_LIFT); ?>">подъём</button>
      <button class="filters__item js-filter" type="button" data-type="<?php echo esc_attr(MEHBAZA_CAT_HAUL); ?>">перевозка</button>
    </div>
  </div>
  <p class="lead lead_offset_bottom">
    Смена — 8 часов. Подача по Москве считается отдельно, по области — по километражу.
    Цены ниже — ориентир на апрель, точную смену считает диспетчер.
  </p>

  <div class="fleet">
    <?php foreach ($items as $item) :
      $cat = $repository->category_slug($item->ID);
      $price = mehbaza_post_field(MEHBAZA_FIELD_EQ_PRICE, $item->ID);
      $spec = mehbaza_post_field(MEHBAZA_FIELD_EQ_SPEC, $item->ID);
      $badge = mehbaza_post_field(MEHBAZA_FIELD_EQ_BADGE, $item->ID);
      $title = get_the_title($item);
      ?>
      <article class="fleet__item" data-cat="<?php echo esc_attr($cat); ?>">
        <div class="fleet__photo">
          <?php echo get_the_post_thumbnail($item, 'large', array('class' => 'fleet__image')); ?>
          <?php if ($badge) : ?>
            <span class="fleet__badge"><?php echo esc_html($badge); ?></span>
          <?php endif; ?>
        </div>
        <div class="fleet__meta">
          <h3 class="fleet__name"><?php echo esc_html($title); ?></h3>
          <?php if ($price) : ?>
            <b class="fleet__price"><?php echo esc_html($price); ?></b>
          <?php endif; ?>
        </div>
        <?php if ($spec) : ?>
          <p class="fleet__spec"><?php echo esc_html($spec); ?></p>
        <?php endif; ?>
        <button class="btn btn_theme_line fleet__order js-order" type="button" data-equipment="<?php echo esc_attr($title); ?>">
          оставить заявку
        </button>
      </article>
    <?php endforeach; ?>
  </div>
</section>
