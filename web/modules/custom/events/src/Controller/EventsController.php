<?php

namespace Drupal\events\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Entity\ConfigEntityBase;
use Drupal\Core\Entity\ContentEntityBase;

class EventsController extends ControllerBase {
    /**
     * @return array
     */
    public function content() {
        //$entityid = \Drupal::routeMatch()->getParameter('events_entity')->id();

        $ids = \Drupal::entityQuery('events_entity')
            ->execute();
        $entityStorage = \Drupal::entityManager()
            ->getStorage('events_entity')
            ->loadMultiple($ids);
        $items1 = [];
        foreach($entityStorage as $cle1) {
            $items1[] = $cle1->getName();
        }
        //ksm($items1);
        $database = \Drupal::database();
        $result = $database->select('events_registered', 'er')
            ->fields('er', ['firstName', 'lasteName'])
            ->execute();

        $items = [];
        foreach($result as $cle => $val) {
            $items[] = [$val->firstName, $val->lasteName, $items1[$cle]];
        }

        return [
            '#type' => 'table',
            '#header' => ['First Name', 'Last Name', 'Event'],
            '#rows' =>  $items,
        ];
    }
}

