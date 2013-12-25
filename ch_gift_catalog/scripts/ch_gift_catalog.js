Drupal.behaviors.ch_gift_catalog = function(context) {
  gift_catalog_options_hide();
  $('#ch-gift-catalog-filters input:radio').change( function() {
    $('#ch-gift-catalog-filters').submit();
  });
  $('#ch-ecard-filters input:radio').change( function() {
    $('#ch-ecard-filters').submit();
  });
  
  $('.ecard-sample a.preview').click( function() {
    var data = {
      sender_name: $('.attributes .attribute-1 input').value(),
      sender_email: $('.attributes .attribute-2 input').value(),
      recipient_name: $('.attributes .attribute-3 input').value(),
      recipient_email: $('.attributes .attribute-4 input').value(),
      message: $('.attributes .attribute-5 input').value()
    };
    return false;
  });
  
  $('.ecard-item a[rel="lightmodal"]').click( function() {
    Drupal.behaviors.date_popup('#modalContainer');
  });
  
  $('.ecard-item a[rel="lightmodal"]').each( function() {
    //var row = $(this).parents('tr.ecard-item');
    //$(this).attr('href', Drupal.settings.ch_ecard.path[0]+' #'+row.attr('id')+' .add-to-cart');
    $(this).attr('href', $(this).attr('href')+'/ajax');
    $(this).attr('rel', 'lightmodal[|width:650px;]');
  });
}
Drupal.behaviors.ch_ecard_lightmodal = function(context) {
  if (Lightbox.disableCloseClick) {
    // close the lightbox when clicking the overlay
    $('#lightbox').click(function() { Lightbox.end('forceClose'); } );
    
    $('#outerImageContainer :submit').click(function() {
      // submit the form
      $('#outerImageContainer, #lightbox').unbind('click');
      return true;
    } );
    
    // don't close the lightbox when clicking in the box
    $('#outerImageContainer, #imageDataContainer').click(function() { return false; } );
  }
}
function gift_catalog_options_hide() {
   var v=document.getElementById("ch-gift-catalog-filters");   
   var elem = document.getElementById("ch-gift-catalog-filters");
   if(elem.action.indexOf("ecard")==-1) {
       var thisObj = eval("document.getElementById('ch-gift-catalog-filters').style");
       thisObj.visibility = "hidden";
       document.getElementById('ch-gift-catalog-filters').style.height='0px';
   } 
   return false;
}