<?php

namespace Drupal\prodi_sekolah\Entity;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface for defining Prodi sekolah entities.
 *
 * @ingroup prodi_sekolah
 */
interface ProdiSekolahInterface extends ContentEntityInterface, EntityChangedInterface, EntityOwnerInterface {

  // Add get/set methods for your configuration properties here.

  /**
   * Gets the Prodi sekolah name.
   *
   * @return string
   *   Name of the Prodi sekolah.
   */
  public function getName();

  /**
   * Sets the Prodi sekolah name.
   *
   * @param string $name
   *   The Prodi sekolah name.
   *
   * @return \Drupal\prodi_sekolah\Entity\ProdiSekolahInterface
   *   The called Prodi sekolah entity.
   */
  public function setName($name);

  /**
   * Gets the Prodi sekolah creation timestamp.
   *
   * @return int
   *   Creation timestamp of the Prodi sekolah.
   */
  public function getCreatedTime();

  /**
   * Sets the Prodi sekolah creation timestamp.
   *
   * @param int $timestamp
   *   The Prodi sekolah creation timestamp.
   *
   * @return \Drupal\prodi_sekolah\Entity\ProdiSekolahInterface
   *   The called Prodi sekolah entity.
   */
  public function setCreatedTime($timestamp);

  /**
   * Returns the Prodi sekolah published status indicator.
   *
   * Unpublished Prodi sekolah are only visible to restricted users.
   *
   * @return bool
   *   TRUE if the Prodi sekolah is published.
   */
  public function isPublished();

  /**
   * Sets the published status of a Prodi sekolah.
   *
   * @param bool $published
   *   TRUE to set this Prodi sekolah to published, FALSE to set it to unpublished.
   *
   * @return \Drupal\prodi_sekolah\Entity\ProdiSekolahInterface
   *   The called Prodi sekolah entity.
   */
  public function setPublished($published);

}
