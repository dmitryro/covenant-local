<?php
// $Id$

/**
 * @file
 * This file contains the Conditional Actions hooks and
 * functions necessary to make the
 * order related entity, conditions, events, and actions work.
 */


/******************************************************************************
 * Conditional Actions Hooks                                                  *
 ******************************************************************************/

/**
 * Implementation of hook_ca_condition().
 */
function ch_donate_ca_condition() {
  $order_arg = array(
    '#entity' => 'uc_order',
  ); // defined in uc_order.ca.inc
  
  $conditions['ch_donate_language_condition'] = array(
    '#title' => t('Check the order language'),
    '#description' => t('Returns TRUE if the order was place in the specified language.'),
    '#category' => t('Order'),
    '#callback' => 'ch_donate_condition_language',
    '#arguments' => array(
      'order' => $order_arg,
    ),
  );
  
  $conditions['ch_donate_currency_condition'] = array(
    '#title' => t('Check the order currency'),
    '#description' => t('Returns TRUE if the order was place in the specified currency.'),
    '#category' => t('Order'),
    '#callback' => 'ch_donate_condition_currency',
    '#arguments' => array(
      'order' => $order_arg,
    ),
  );
  
  return $conditions;
}


// Check the current order language
function ch_donate_condition_language($order, $settings) {
    return $order->data['language'] == $settings['order_language_code_value'];
}
function ch_donate_condition_language_form($form_state, $settings = array()) {
  $form['order_language_code_value'] = array(
    '#type' => 'textfield',
    '#title' => t('Order language code'),
    '#description' => t('Specify a value to compare the order language code against.'),
    '#default_value' => $settings['order_language_code_value'],
    '#size' => 6,
  );
  return $form;
}

// Check the order currency
function ch_donate_condition_currency($order, $settings) {
    return $order->data['currency'] == $settings['order_currency_code_value'];
}
function ch_donate_condition_currency_form($form_state, $settings = array()) {
  $form['order_currency_code_value'] = array(
    '#type' => 'textfield',
    '#title' => t('Order currency code'),
    '#description' => t('Specify a value to compare the order currency code against.'),
    '#default_value' => $settings['order_currency_code_value'],
    '#size' => 6,
  );
  return $form;
}