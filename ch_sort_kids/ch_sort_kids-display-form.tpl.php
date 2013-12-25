<?php
  // Add table javascript.
  drupal_add_tabledrag('kid_profiles', 'order', 'sibling', 'kid_profile-weight');
?>
<table id="kid_profiles">
  <thead>
    <tr>
      <th><?php print t('Page Title'); ?></th>
      <th><?php print t('Name'); ?></th>
      <th><?php print t('Weight'); ?></th>
      <th></th>
    </tr>
  </thead>
  <tbody>
  <?php $count = 0; ?>
  <?php foreach( $profiles as $nid=>$data ): ?>
    <tr class="draggable  <?php print $count % 2 == 0 ? 'odd' : 'even'; ?>">
      <td><?php print $data['link']; ?></td>
      <td><?php print $data['name']; ?></td>
      <td><?php print $data['select']; ?></td>
    </tr>
    <?php $count++; ?>
  <?php endforeach; ?>
  </tbody>

</table>

<?php print $form_submit; ?>