<?php
// $Id$
/**
 * Loosely based on node.tpl.php
 */
?>
<div id="ch_gift_catalog" class="gift-catalog">

<?php if ($page == 0): ?>
  <h2><?php print $title ?></h2>
<?php endif; ?>
<script language="JavaScript" src="https://seal.networksolutions.com/siteseal/javascript/siteseal.js" type="text/javascript"></script>
<script language="JavaScript">
   var browserName = navigator.appName;
   if(browserName == "Microsoft Internet Explorer") {
       	document.write('<div style="margin-left:400px;margin-top:-30px;">');
       	SiteSeal("https://seal.networksolutions.com/images/basicrecgreen.gif","NETSP","none");
       	document.write('</div>');

    } else {
              document.write('<div style="float:right">');
       	SiteSeal("https://seal.networksolutions.com/images/basicrecgreen.gif","NETSP","none");
       	document.write('</div>');
    }
</script>

  
<div class="content clear-block">
    <?php print $content ?>
  </div>

</div>