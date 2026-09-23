<?php
if (!defined('ABSPATH')) {
  exit;
}

function mehbaza_disable_lead_block_editor($use_block_editor, $post_type) {
  if ($post_type === MEHBAZA_POST_LEAD) {
    return false;
  }
  return $use_block_editor;
}

function mehbaza_add_lead_metabox() {
  add_meta_box(
    'mehbaza-lead-details',
    'Данные заявки',
    'mehbaza_render_lead_metabox',
    MEHBAZA_POST_LEAD,
    'normal',
    'high'
  );
}

function mehbaza_render_lead_metabox($post) {
  $lead = (new Mehbaza_Lead_Repository())->find($post->ID);
  $rows = array(
    'Имя' => isset($lead['name']) ? $lead['name'] : '',
    'Телефон' => isset($lead['phone']) ? $lead['phone'] : '',
    'Техника' => isset($lead['equipment']) ? $lead['equipment'] : '',
    'Комментарий' => isset($lead['comment']) ? $lead['comment'] : '',
  );
  ?>
  <table class="form-table" role="presentation">
    <tbody>
      <?php foreach ($rows as $label => $value) : ?>
        <tr>
          <th scope="row"><?php echo esc_html($label); ?></th>
          <td><?php echo $value !== '' ? nl2br(esc_html($value)) : '—'; ?></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
  <?php
}

add_filter('use_block_editor_for_post_type', 'mehbaza_disable_lead_block_editor', 10, 2);
add_action('add_meta_boxes', 'mehbaza_add_lead_metabox');
