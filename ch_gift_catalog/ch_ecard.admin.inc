<?php
// $Id$

/**
 * @file
 * Administration page callbacks for the ch_gift_catalog module
 */

/**
 * Build the donation settings form
 */
function ch_ecard_admin_settings() {
  $form = array();
  
  $form['ch_ecard_page_title'] = array(
    '#type' => 'textfield',
    '#title' => t('Ecard Title'),
    '#description' => t('The title of the ecard page'),
    '#default_value' => variable_get('ch_ecard_page_title', 'eCards'),
  );
  
  $form['ch_ecard_page_header'] = array(
    '#type' => 'textarea',
    '#title' => t('Ecard Header'),
    '#description' => t('The text that appears above the ecard catalog'),
    '#default_value' => variable_get('ch_ecard_page_header', ''),
  );
  
  $form['ch_ecard_page_footer'] = array(
    '#type' => 'textarea',
    '#title' => t('Ecard Footer'),
    '#description' => t('The text that appears below the ecard catalog'),
    '#default_value' => variable_get('ch_ecard_page_footer', ''),
  );
  
  return system_settings_form($form);
}