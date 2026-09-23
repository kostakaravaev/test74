<?php
if (!defined('ABSPATH')) {
  exit;
}
get_header();
get_template_part('template-parts/hero');
get_template_part('template-parts/about');
get_template_part('template-parts/fleet');
get_template_part('template-parts/plus');
get_template_part('template-parts/reviews');
get_template_part('template-parts/request');
get_template_part('template-parts/contacts');
get_footer();
