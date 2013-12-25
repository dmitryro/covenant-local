Drupal.behaviors.ch_donate = function(context) {

  $('#tribute-pane .address-pane-table', context).hide();

  $('#tribute-pane #edit-panes-tribute-acknowledge').click( function() {

    if ( this.checked ) {

      $('#tribute-pane .address-pane-table').slideDown();

    } else {

      $('#tribute-pane .address-pane-table').slideUp();

    }

  });

  if ( $('#edit-panes-donate-amount-other:checked').length < 1 ) {
    $('#edit-panes-donate-other-amount').hide();
  } else {
    $('<span id="other_amt_dollar_sign">$</span>').insertAfter('#edit-panes-donate-amount-other');
  }

  $('#donate-pane .form-radios [name="panes[donate][amount]"]').click( function() {
    var val = $('#donate-pane .form-radios [name="panes[donate][amount]"]:checked').val();
    if ( val == 'other' ) {
      if ( $('#edit-panes-donate-other-amount').is(':hidden') ) {
        $('#edit-panes-donate-other-amount').show().val('').focus();
        $('<span id="other_amt_dollar_sign">$</span>').insertAfter('#edit-panes-donate-amount-other');
      }
    } else {
      $('#edit-panes-donate-other-amount').hide();
      $('#edit-panes-donate-other-amount').val(val);
      $('#other_amt_dollar_sign').remove();
    }
  });

  $('#edit-panes-donate-other-amount').click( function() {
    $('#edit-panes-donate-amount-other-wrapper input').not(':checked').click();
  });

  

  var copy_address_message = 'Please check this box if the billing information is NOT the same as above.';

  if ( $('#uc-cart-checkout-form').hasClass('spanish-donation-form') ) {

    copy_address_message = 'Datos de facturación no son iguales a la información del donante arriba.';

  }

  $('#edit-panes-billing-copy-address').click();

  $('#edit-panes-billing-copy-address-wrapper').hide().before('<div id="edit-panes-billing-copy-address-wrapper-alt" class="form-item"><label class="option" for="edit-panes-billing-copy-address-alt"><input id="edit-panes-billing-copy-address-alt" class="form-checkbox" type="checkbox" />'+copy_address_message+'</label></div>');

  $('#edit-panes-billing-copy-address-alt').get(0).checked = !($('#edit-panes-billing-copy-address').get(0).checked);

  

  $('#edit-panes-billing-copy-address-alt').click( function() {

    $('#edit-panes-billing-copy-address').click();

  });

  

  $('#uc-cart-checkout-form').submit( function() {
    var copy = $('#edit-panes-billing-copy-address-alt').get(0);
    if ( copy && !copy.checked ) {
      uc_cart_copy_address( !copy.checked, 'delivery', 'billing' );
    }

    $('#edit-continue').attr('disabled', 'disabled');

    return true;

  });

}