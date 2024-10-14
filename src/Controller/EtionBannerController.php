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
    if (strpos($banner_title, '.jpg') === FALSE) {
      $url = $this->etionBanner->getUrl($banner_title);
      return new TrustedRedirectResponse($url);
    }
    else {
      $image = $this->etionBanner->getImage($banner_title);

      $response = new Response();
      $response->headers->set('Content-Type', 'image/jpeg');
      $response->setContent($image);

      return $response;
    }
  }

  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('etion_banner.banner')
    );
  }
}
