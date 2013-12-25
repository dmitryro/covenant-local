<?php

// $Id$



/**

 * @file

 * Administration page callbacks for the ch_donate module

 */



/**

 * Build the donation settings form

 */

function ch_donate_admin_settings() {
    
  $form = array();

  

  $form['ch_donate_title'] = array(

    '#type' => 'textfield',

    '#title' => t('Donate Page Title'),

    '#description' => t('The title of the donation page.'),

    '#default_value' => variable_get('ch_donate_title', 'Donate'),

  );




  $form['ch_donate_monthly_title'] = array(

    '#type' => 'textfield',

    '#title' => t('Donate Monthly Page Title'),

    '#description' => t('The title of the donation page.'),

    '#default_value' => variable_get('ch_donate_monthly_title', ''),

  );

  $form['ch_donate_CAD_title'] = array(

    '#type' => 'textfield',

    '#title' => t('Donate Page Title (Canadian Dollars)'),

    '#description' => t('The title of the donation page.'),

    '#default_value' => variable_get('ch_donate_CAD_title', 'Donate (Canadian Dollars)'),

  );

  

  $form['ch_donate_spanish_title'] = array(

    '#type' => 'textfield',

    '#title' => t('Donate Page Title (Spanish)'),

    '#description' => t('The title of the donation page in Spanish.'),

    '#default_value' => variable_get('ch_donate_spanish_title', 'Donación'),

  );

  

  $form['ch_donate_intro'] = array(

    '#type' => 'textarea',

    '#title' => t('Intro Text'),

    '#description' => t('The text that will appear above the donation form.'),

    '#default_value' => variable_get('ch_donate_intro', ''),

  );

  
  $form['ch_donate_monthly_intro'] = array(

    '#type' => 'textarea',

    '#title' => t('Monthly Intro Text'),

    '#description' => t('The text that will appear above the donation form.'),

    '#default_value' => variable_get('ch_donate_monthly_intro', ''),

  );
  
  $form['ch_donate_CAD_intro'] = array(

    '#type' => 'textarea',

    '#title' => t('Canadian Intro Text'),

    '#description' => t('The text that will appear above the Canadian donation form.'),

    '#default_value' => variable_get('ch_donate_CAD_intro', ''),

  );

  

  $form['ch_donate_spanish_intro'] = array(

    '#type' => 'textarea',

    '#title' => t('Spanish Intro Text'),

    '#description' => t('The text that will appear above the Spanish donation form.'),

    '#default_value' => variable_get('ch_donate_spanish_intro', ''),

  );

  

  $form['ch_donate_suggestions'] = array(

    '#type' => 'textarea',

    '#title' => t('Suggested Donation Amounts'),

    '#description' => t('List suggested donation amounts (one per line). The user will have the option of donating a different amount.'),

    '#default_value' => variable_get('ch_donate_suggestions', "100\n250\n500\n750\n1000\n2500\n5000"),

  );

  $form['ch_donate_monthly_suggestions'] = array(

    '#type' => 'textarea',

    '#title' => t('Suggested Monthly Donation Amounts'),

    '#description' => t('List suggested donation amounts (one per line). The user will have the option of donating a different amount.'),

    '#default_value' => variable_get('ch_donate_monthly_suggestions', "20\n50\n75\n100\n200\n300\n500"),

  );

  $form['ch_donate_review_header'] = array(

    '#type' => 'textfield',

    '#title' => t('Checkout Review Title'),

    '#description' => t('The title for the checkout review page'),

    '#default_value' => variable_get('ch_donate_review_header', 'Review Order'),

  );

  

  return system_settings_form($form);

}