<?php

namespace Drupal\prodi_sekolah\Form;

use Drupal\Core\Entity\ContentEntityForm;
use Drupal\Core\Form\FormStateInterface;

/**
 * Form controller for Prodi sekolah edit forms.
 *
 * @ingroup prodi_sekolah
 */
class ProdiSekolahForm extends ContentEntityForm {

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    /* @var $entity \Drupal\prodi_sekolah\Entity\ProdiSekolah */
    $form = parent::buildForm($form, $form_state);
	$form['name']['#access'] = FALSE;

    $entity = $this->entity;

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function getViolations(FormStateInterface $form_state){
  
    $entity = $this->entity;
	
    $query = \Drupal::entityQuery('prodi_sekolah')
		->condition('pilihan_sekolah_id', $form_state->getValue('pilihan_sekolah_id')[0]['target_id'], '=')
		->condition('kompetensi_keahlian_id', $form_state->getValue('kompetensi_keahlian_id')[0]['target_id'], '=')
		->range('0', '1')
		->execute();
	
	return (bool)$query;
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    /* @var $entity \Drupal\wilayah_indonesia_province\Entity\Province */		
	parent::validateForm($form, $form_state);

    $entity = $this->entity;

    if($this->getViolations($form_state)){
	    $form_state->setErrorByName('kompetensi_keahlian_id',"Kompetensi keahlian tersebut sudah ada untuk sekolah yang dimaksud");
	}
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    $entity = $this->entity;
    $entity->set('name', $entity->pilihan_sekolah_id->entity->label() .' : '. $entity->kompetensi_keahlian_id->entity->label());
    
	$status = parent::save($form, $form_state);

    switch ($status) {
      case SAVED_NEW:
        drupal_set_message($this->t('Created the %label Prodi sekolah.', [
          '%label' => $entity->label(),
        ]));
        break;

      default:
        drupal_set_message($this->t('Saved the %label Prodi sekolah.', [
          '%label' => $entity->label(),
        ]));
    }
    $form_state->setRedirect('entity.prodi_sekolah.canonical', ['prodi_sekolah' => $entity->id()]);
  }

}
