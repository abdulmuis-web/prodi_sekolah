<?php

namespace Drupal\prodi_sekolah;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityListBuilder;
use Drupal\Core\Link;

/**
 * Defines a class to build a listing of Prodi sekolah entities.
 *
 * @ingroup prodi_sekolah
 */
class ProdiSekolahListBuilder extends EntityListBuilder {


  /**
   * {@inheritdoc}
   */
  public function buildHeader() {
    $header['id'] = $this->t('ID');
    $header['pilihan_sekolah'] = $this->t('Sekolah');
    $header['name'] = $this->t('Prodi');
    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity) {
    /* @var $entity \Drupal\prodi_sekolah\Entity\ProdiSekolah */
    $row['id'] = $entity->id();
    $row['pilihan_sekolah'] = Link::createFromRoute(
      $entity->pilihan_sekolah_id->entity->label(),
      'entity.pilihan_sekolah.canonical',
      ['pilihan_sekolah' => $entity->pilihan_sekolah_id->target_id]
    );
    $row['name'] = Link::createFromRoute(
      $entity->label(),
      'entity.prodi_sekolah.canonical',
      ['prodi_sekolah' => $entity->id()]
    );
    return $row + parent::buildRow($entity);
  }

}
