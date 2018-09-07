<?php
/**
 * Created by PhpStorm.
 * User: linpoo
 * Date: 2018/9/7
 * Time: 下午4:30.
 */

namespace App\EventSubscriber;

use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\ORM\Events;
use Doctrine\Common\EventSubscriber;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;

class EntityCreateOrCreate implements EventSubscriber
{
    public function getSubscribedEvents()
    {
        return [
            Events::prePersist,
            Events::preUpdate,
        ];
    }

    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getObject();
        $entity->setCreatedAt(new \DateTime());
    }

    public function preUpdate(PreUpdateEventArgs $args)
    {
        $entity = $args->getObject();
        $entity->setUpdatedAt(new \DateTime());
    }
}
