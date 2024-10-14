<?php

namespace Drupal\etion_banner\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\etion_banner\EtionBanner;

use \Drupal\Core\Routing\TrustedRedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Response;

class EtionBannerController extends ControllerBase {
  protected EtionBanner $etionBanner;

  public function __construct(EtionBanner $etionBanner) {
    $this->etionBanner = $etionBanner;
  }

  public function process(string $banner_title) {
    $this->etionBanner->getUrl($banner_title);
    if (strpos($banner_title, '.jpg') === FALSE) {
      $url = 'https://www.etion.be/kennis/z-extra-geert-janssens-over-onze-concurrentiekracht';
      return new TrustedRedirectResponse($url);
    }
    else {
      $filepath = 'https://www.etion.be/sites/default/files/styles/persoon_square/public/2024-09/Z-extra-Geert-Janssens-concurrentiekracht-1366.jpg';

      $response = new Response();
      $response->headers->set('Content-Type', 'image/jpeg');
      $response->setContent(file_get_contents($filepath));

      return $response;
    }
  }

  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('etion_banner.banner')
    );
  }
}
