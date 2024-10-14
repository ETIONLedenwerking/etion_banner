<?php

namespace Drupal\etion_banner;

use \Drupal\node\Entity\Node;

class EtionBanner {
  public function getUrl(string $bannerTitle) {
    $node = $this->loadBannerNode($bannerTitle);
    die($node->getTitle());
  }

  public function getImage(string $bannerTitle) {

  }

  private function loadBannerNode(string $bannerTitle): ?Node {
    $nids = \Drupal::entityQuery('e_mail_banner')
      ->condition('title', $bannerTitle)
      ->execute();

    if ($nids) {
      return Node::load($nids[0]);
    }
    else {
      return null;
    }
  }
}
