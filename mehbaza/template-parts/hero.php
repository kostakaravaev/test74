<?php
if (!defined('ABSPATH')) {
  exit;
}

$slides = (new Mehbaza_Slide_Repository())->all();
if (empty($slides)) {
  return;
}
$first = true;
?>
<section class="hero">
  <div class="hero__carousel carousel slide" id="heroCarousel" data-ride="carousel" data-interval="6500">
    <ol class="hero__indicators carousel-indicators">
      <?php foreach ($slides as $index => $slide) : ?>
        <li
          class="hero__indicator<?php echo $index === 0 ? ' active' : ''; ?>"
          data-target="#heroCarousel"
          data-slide-to="<?php echo esc_attr((string) $index); ?>"
        ></li>
      <?php endforeach; ?>
    </ol>
    <div class="carousel-inner">
      <?php foreach ($slides as $slide) :
        $image = get_the_post_thumbnail_url($slide, 'full');
        $kicker = mehbaza_post_field(MEHBAZA_FIELD_KICKER, $slide->ID);
        $title = mehbaza_post_field(MEHBAZA_FIELD_SLIDE_TITLE, $slide->ID, get_the_title($slide));
        $price = mehbaza_post_field(MEHBAZA_FIELD_SLIDE_PRICE, $slide->ID);
        $link = mehbaza_post_field(MEHBAZA_FIELD_SLIDE_LINK, $slide->ID, home_url('/#park'));
        $heading_tag = $first ? 'h1' : 'h2';
        ?>
        <div class="carousel-item<?php echo $first ? ' active' : ''; ?>">
          <div class="hero__slide" style="background-image: url('<?php echo esc_url($image); ?>')"></div>
          <div class="hero__caption carousel-caption">
            <?php if ($kicker) : ?>
              <span class="hero__kicker"><?php echo esc_html($kicker); ?></span>
            <?php endif; ?>
            <<?php echo $heading_tag; ?> class="hero__title"><?php echo esc_html($title); ?></<?php echo $heading_tag; ?>>
            <?php if ($price) : ?>
              <p class="hero__price"><?php echo esc_html($price); ?></p>
            <?php endif; ?>
            <a class="btn btn_theme_white hero__more" href="<?php echo esc_url($link); ?>">
              <?php echo esc_html(MEHBAZA_MORE_LABEL); ?>
            </a>
          </div>
        </div>
        <?php
        $first = false;
      endforeach; ?>
    </div>
    <a class="hero__control hero__control_prev carousel-control-prev" href="#heroCarousel" role="button" data-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="sr-only">Назад</span>
    </a>
    <a class="hero__control hero__control_next carousel-control-next" href="#heroCarousel" role="button" data-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="sr-only">Вперёд</span>
    </a>
  </div>
</section>
