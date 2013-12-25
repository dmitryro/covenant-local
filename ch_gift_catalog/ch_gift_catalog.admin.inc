<?php
// $Id$

/**
 * @file
 * Administration page callbacks for the ch_gift_catalog module
 */

/**
 * Build the donation settings form
 */
function ch_gift_catalog_admin_settings() {
  $form = array();
  
  $form['ch_gift_catalog_page_title'] = array(
    '#type' => 'textfield',
    '#title' => t('Gift Catalog Title'),
    '#description' => t('The title of the gift catalog page'),
    '#default_value' => variable_get('ch_gift_catalog_page_title', 'Gift Catalog'),
  );
  
  $form['ch_gift_catalog_page_header'] = array(
    '#type' => 'textarea',
    '#title' => t('Gift Catalog Header'),
    '#description' => t('The text that appears above the gift catalog'),
    '#default_value' => variable_get('ch_gift_catalog_page_header', ''),
  );
  
  $form['ch_gift_catalog_page_footer'] = array(
    '#type' => 'textarea',
    '#title' => t('Gift Catalog Footer'),
    '#description' => t('The text that appears below the gift catalog'),
    '#default_value' => variable_get('ch_gift_catalog_page_footer', ''),
  );
  
  return system_settings_form($form);
}