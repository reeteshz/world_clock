<?php  
/**  
 * @file  
 * Contains Drupal\world_clock\Form\ClockConfigurationForm.  
 */  
namespace Drupal\world_clock\Form;  
use Drupal\Core\Form\ConfigFormBase;  
use Drupal\Core\Form\FormStateInterface;  

class ClockConfigurationForm extends ConfigFormBase {  
    /**  
     * {@inheritdoc}  
     */  
  protected function getEditableConfigNames() {  
    return [  
      'clock_configuration.settings',  
    ];  
  }  

    /**  
     * {@inheritdoc}  
     */  
  public function getFormId() {  
    return 'clock_configuration_form';  
  } 

    /**  
   * {@inheritdoc}  
   */  
  public function buildForm(array $form, FormStateInterface $form_state) {  
    $config = $this->config('clock_configuration.settings');  

    $form['country'] = [  
      '#type' => 'textfield',  
      '#title' => $this->t('Country'),  
      '#description' => $this->t('Enter Country'),  
      '#default_value' => $config->get('country'),
    ]; 

    $form['city'] = [  
        '#type' => 'textfield',  
        '#title' => $this->t('City'),  
        '#description' => $this->t('Enter City'),  
        '#default_value' => $config->get('city'),
      ];

      $form['timezone'] = [
        '#type' => 'select',
        '#title' => $this
          ->t('Select Timezone'),
        '#options' => [
          'America/Chicago' => $this->t('America/Chicago'),
          'America/New_York' => $this->t('America/New York'),
          'Asia/Tokyo' => $this->t('Asia/Tokyo'),
          'Asia/Dubai' => $this->t('Asia/Dubai'),
          'Asia/Kolkata' => $this->t('Asia/Kolkata'),
          'Europe/Amsterdam' => $this->t('Europe/Amsterdam'),
          'Europe/Oslo' => $this->t('Europe/Oslo'),
          'Europe/London' => $this->t('Europe/London'),
        ],
        '#default_value' => $config->get('timezone'),
      ];

    return parent::buildForm($form, $form_state);  
  }
  
   /**  
   * {@inheritdoc}  
   */  
  public function submitForm(array &$form, FormStateInterface $form_state) {  
    parent::submitForm($form, $form_state);  
    $this->config('clock_configuration.settings')->set('country', $form_state->getValue('country'))->save();
    $this->config('clock_configuration.settings')->set('city', $form_state->getValue('city'))->save();
    $this->config('clock_configuration.settings')->set('timezone', $form_state->getValue('timezone'))->save();
  }  

}  