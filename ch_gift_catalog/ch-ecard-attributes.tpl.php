<?php
// $Id$
?>
<div id="node-<?php print $item->nid; ?>" class="node">

<h3>Message Information</h3>

<?php print $form; ?>
<div class="ecard-sample">
  <p><?php print $image; ?></p>
</div>

</div>
<script type="text/javascript">
  // enable appropriate behaviors when working in a lightbox
  Drupal.behaviors.ch_ecard_lightmodal();
</script>
