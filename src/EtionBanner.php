<?php

namespace Drupal\etion_banner;

use \Drupal\node\Entity\Node;

class EtionBanner {
  public function getUrl(string $bannerTitle) {
    $node = $this->loadBannerNode($bannerTitle);
    return $node->get('field_doorsturen_naar')->getValue()[0]['uri'];
  }

  public function getImage(string $bannerTitle) {
    $bannerTitle = str_replace('.jpg', '', $bannerTitle);

    $node = $this->loadBannerNode($bannerTitle);
    $targetId = $node->get('field_afbeelding')->getValue()[0]['target_id'];
    $file = \Drupal\file\Entity\File::load($targetId);

    return file_get_contents($file->getFileUri());
  }

  private function loadBannerNode(string $bannerTitle): ?Node {
    $nids = \Drupal::entityQuery('node')
      ->condition('type', 'e_mail_banner')
      ->condition('title', $bannerTitle)
      ->accessCheck(FALSE)
      ->execute();

    if (!empty($nids))  {
      return Node::load(reset($nids));
    }
    else {
      return null;
    }
  }
}
