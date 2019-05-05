<?php

namespace Drupal\prodi_sekolah\Controller;

use Drupal\Component\Datetime\TimeInterface;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Routing\RouteMatchInterface;
use Drupal\profile\Entity\ProfileInterface;
use Drupal\profile\Entity\ProfileTypeInterface;
use Drupal\profile\Entity\Profile;
use Drupal\user\UserInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

use Drupal\prodi_sekolah\Entity\ProdiSekolahInterface;
use Drupal\prodi_sekolah\Entity\ProdiSekolah;
use Drupal\kompetensi_keahlian\Entity\KompetensiKeahlianInterface;
use Drupal\kompetensi_keahlian\Entity\KompetensiKeahlian;

/**
 * Class ProdiSekolahController.
 */
class ProdiSekolahController extends ControllerBase {

  /**
   * The time.
   *
   * @var \Drupal\Core\Routing\RouteMatchInterface
   */
  protected $time;

  /**
   * The route.
   *
   * @var \Drupal\Component\Datetime\TimeInterface
   */
  protected $route_match;

  /**
   * Constructs a new ProfileController object.
   *
   * @param \Drupal\Component\Datetime\TimeInterface $time
   *   The time.
   */
  public function __construct(TimeInterface $time, RouteMatchInterface $route_match) {
    $this->time = $time;
    $this->route_match = $route_match;
  }
  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('datetime.time'),
	  $container->get('current_route_match')

    );
  }

  public function getProdiSekolah($sekolah, $param){
    $query = \Drupal::entityQuery('prodi_sekolah')
	  ->condition('pilihan_sekolah_id', $sekolah->id(), '=')
	  ->condition('kompetensi_keahlian_id', $param, '=')
	  ->range('0', '1');
	$result = $query->execute();
	
	return $result;
  }

  public function getActiveProfile($current_user){
    /** @var \Drupal\profile\Entity\ProfileInterface|bool $active_profile */
    $active_profile = $this->entityTypeManager()
      ->getStorage('profile')
      ->loadByUser($current_user, 'admin_sekolah');
	
	return $active_profile;
  }

  /**
   * Addprodisekolah.
   *
   * @return string
   *   Return Hello string.
   */
  public function addProdiSekolah(RouteMatchInterface $route_match) {
	
	\Drupal::service('page_cache_kill_switch')->trigger();
	
	$current_user = \Drupal::currentUser();
    $param = $route_match->getParameters()->get('kompetensi_keahlian');
	$active_profile = $this->getActiveProfile($current_user);
	if($active_profile){
	  $sekolah = $active_profile->get('field_sekolah')->entity;
      $prodi_sekolah = $this->getProdiSekolah($sekolah, $param);
	  if(!$prodi_sekolah){
        $prodi_sekolah = $this->entityTypeManager()->getStorage('prodi_sekolah')->create([
          'pilihan_sekolah_id' => $sekolah->id(),
          'kompetensi_keahlian_id' => $param,
        ]);
        return $this->entityFormBuilder()->getForm($prodi_sekolah, 'add', ['user_id' => $current_user->id(), 'created' => $this->time->getRequestTime()]);
	  }
	  return [
        '#type' => 'markup',
        '#markup' => $this->t('Sekolah Anda sudah memiliki program studi ini '),
      ];
	}

    return [
      '#type' => 'markup',
      '#markup' => $this->t('Anda tidak memiliki akses untuk menambah program studi pada sekolah'),
    ];
  }
  /**
   * The _title_callback for the add profile form route.
   *
   * @param \Drupal\prodi_sekolah\Entity\ProdiSekolahInterface $prodi_sekolah
   *   The current prodi_sekolah.
   *
   * @return string
   *   The page title.
   */
  //public function addPageTitle(KompetensiKeahlianInterface $kompetensi_keahlian) {
  public function addPageTitle(RouteMatchInterface $route_match) {
    $param = $route_match->getParameters()->get('kompetensi_keahlian');
	$entity_type_manager = \Drupal::entityTypeManager();
    $kompetensi_keahlian = $entity_type_manager->getStorage('kompetensi_keahlian')->load($param);
	
    return $this->t('Tambah @kompetensi_keahlian pada Sekolah.', array('@kompetensi_keahlian' => $kompetensi_keahlian->label()));
  }


}
