<?php
if (!defined('ABSPATH')) {
  exit;
}
get_header();
?>
<section class="section">
  <h1 class="title"><?php the_title(); ?></h1>
  <?php
  if (have_posts()) {
    while (have_posts()) {
      the_post();
      the_content();
    }
  }
  ?>
</section>
<?php
get_footer();
