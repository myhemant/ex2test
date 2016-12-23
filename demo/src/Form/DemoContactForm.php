<?php

/**
 * @file
 * Contains \Drupal\demo\Form\DemoContactForm.
 */

namespace Drupal\demo\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;


class DemoContactForm extends ConfigFormBase {

    /**
     * {@inheritdoc}
     */
    public function getFormID() {
        return 'demoform';
    }

    /**
     * {@inheritdoc}
     */
    protected function getEditableConfigNames() {
        return [
            'demo.settings',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(array $form, FormStateInterface $form_state) {

        $form['dec'] = array(
            '#markup' => t("Demo conatct form description"),
        );
       
		$form['name'] = array(
            '#type' => 'textfield',
            '#title' => t('Name'),
			'#size' => 30, 
            '#description' => t('Enter your name'),
			 '#required' => TRUE,
           
        );
        
        $form['message'] = array(
            '#type' => 'textarea',
            '#title' => t('Message'),
			'#description' => t('Enter a text message'),
			 '#required' => TRUE,
            
        );
		
		$form['submit'] = array('#type' => 'submit', '#value' => t('Submit'));
		
		return $form;
      
    }
	
	/**
   * {@inheritdoc}
   */
    public function validateForm(array &$form, FormStateInterface $form_state) {
		
		if($form_state->getValue('name') == ''){
			$form_state->setErrorByName('Name', $this->t('Please enter the name.'));
			
		}else if($form_state->getValue('message') == ''){
			$form_state->setErrorByName('message', $this->t('Please enter the Message.'));
		}
      
    }

    /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
		$name 	 = $form_state->getValue('name');
		$message = $form_state->getValue('message');
  
		$query = \Drupal::database()->insert('demo_contact');
		$query->fields([
		  'name',
		  '	message'
		]);
		$query->values([
		  $name,
		  $message
		]);
		$query->execute();
		
    foreach ($form_state->getValues() as $key => $value) {
	  if($key == 'name' || $key == 'message' ){	
		//drupal_set_message($key . ': ' . $value);
	  }
    }
	
	drupal_set_message('mesage' . ': ' . 'Form data is stored in demo_contact table');
   }
}
