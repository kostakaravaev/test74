<?php
if (!defined('ABSPATH')) {
  exit;
}
$phone = mehbaza_phone();
?>
    </div>

    <div class="bottom-bar">
      <a class="bottom-bar__link" href="<?php echo esc_url(mehbaza_phone_href($phone)); ?>">позвонить</a>
      <a class="bottom-bar__link bottom-bar__link_accent" href="<?php echo esc_url(home_url('/#request')); ?>">заявка</a>
    </div>

    <div class="modal fade" id="callbackModal" tabindex="-1" role="dialog" aria-labelledby="callbackTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content callback">
          <div class="callback__header modal-header">
            <h3 class="callback__title modal-title" id="callbackTitle">Заказать звонок</h3>
            <button type="button" class="close" data-dismiss="modal" aria-label="Закрыть">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="callback__body modal-body">
            <?php get_template_part('template-parts/form', null, array('agree_id' => 'agreeModal', 'submit_label' => 'перезвоните мне')); ?>
          </div>
        </div>
      </div>
    </div>
    <?php wp_footer(); ?>
  </body>
</html>
