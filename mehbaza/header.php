<?php
if (!defined('ABSPATH')) {
  exit;
}
$phone = mehbaza_phone();
$phone_href = mehbaza_phone_href($phone);
$note = mehbaza_header_note();
$email = mehbaza_email();
$menu_args = array(
  'theme_location' => MEHBAZA_MENU_HEADER,
  'container' => 'nav',
  'container_class' => 'topbar__nav',
  'fallback_cb' => false,
);
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
  <head>
    <meta charset="<?php bloginfo('charset'); ?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="icon" href="<?php echo esc_url(get_template_directory_uri() . '/assets/img/favicon.svg'); ?>" type="image/svg+xml" />
    <?php wp_head(); ?>
  </head>
  <body <?php body_class('page'); ?>>
    <?php wp_body_open(); ?>
    <div class="page__overlay js-overlay"></div>

    <aside class="sidebar" id="sideNav">
      <button class="sidebar__close js-close-nav" type="button" aria-label="Закрыть меню">×</button>
      <a class="brand" href="<?php echo esc_url(home_url('/')); ?>">
        <span class="brand__mark">МБ</span>
        <span class="brand__text">
          <strong class="brand__name">МЕХБАЗА</strong>
          <span class="brand__caption">аренда техники · с 2009</span>
        </span>
      </a>

      <nav class="sidebar__nav" aria-label="Парк техники">
        <div class="sidebar__label">парк техники</div>
        <a class="sidebar__link js-filter" href="<?php echo esc_url(home_url('/#park')); ?>" data-type="<?php echo esc_attr(MEHBAZA_CAT_EARTH); ?>">Экскаваторы</a>
        <a class="sidebar__link js-filter" href="<?php echo esc_url(home_url('/#park')); ?>" data-type="<?php echo esc_attr(MEHBAZA_CAT_EARTH); ?>">Экскаваторы-погрузчики</a>
        <a class="sidebar__link js-filter" href="<?php echo esc_url(home_url('/#park')); ?>" data-type="<?php echo esc_attr(MEHBAZA_CAT_LIFT); ?>">Автокраны</a>
        <a class="sidebar__link js-filter" href="<?php echo esc_url(home_url('/#park')); ?>" data-type="<?php echo esc_attr(MEHBAZA_CAT_HAUL); ?>">Самосвалы</a>
        <a class="sidebar__link js-filter" href="<?php echo esc_url(home_url('/#park')); ?>" data-type="<?php echo esc_attr(MEHBAZA_CAT_LIFT); ?>">Автовышки</a>
        <a class="sidebar__link js-filter" href="<?php echo esc_url(home_url('/#park')); ?>" data-type="<?php echo esc_attr(MEHBAZA_CAT_EARTH); ?>">Погрузчики</a>
        <a class="sidebar__link js-filter" href="<?php echo esc_url(home_url('/#park')); ?>" data-type="<?php echo esc_attr(MEHBAZA_CAT_EARTH); ?>">Бульдозеры</a>

        <div class="sidebar__label">на сайте</div>
        <?php
        wp_nav_menu(array(
          'theme_location' => MEHBAZA_MENU_HEADER,
          'container' => false,
          'menu_class' => 'sidebar__menu',
          'fallback_cb' => false,
        ));
        ?>
      </nav>

      <div class="sidebar__foot">
        <a class="sidebar__phone" href="<?php echo esc_url($phone_href); ?>"><?php echo esc_html($phone); ?></a>
        <a class="sidebar__mail" href="mailto:<?php echo esc_attr($email); ?>"><?php echo esc_html($email); ?></a>
        <button class="btn" type="button" data-toggle="modal" data-target="#callbackModal">Заказать звонок</button>
      </div>
    </aside>

    <div class="page__main" id="top">
      <header class="topbar">
        <a class="topbar__phone" href="<?php echo esc_url($phone_href); ?>"><?php echo esc_html($phone); ?></a>
        <?php wp_nav_menu($menu_args); ?>
        <div class="topbar__note"><?php echo esc_html($note); ?></div>
      </header>

      <div class="mobile-bar">
        <button class="burger js-open-nav" type="button" aria-label="Открыть меню">
          <span class="burger__line"></span>
        </button>
        <a class="brand brand_compact" href="<?php echo esc_url(home_url('/')); ?>">
          <span class="brand__mark">МБ</span>
          <span class="brand__text">
            <strong class="brand__name">МЕХБАЗА</strong>
            <span class="brand__caption">с 2009</span>
          </span>
        </a>
        <a class="mobile-bar__phone" href="<?php echo esc_url($phone_href); ?>"><?php echo esc_html($phone); ?></a>
      </div>
