<?php

namespace App\Events;

use App\Traits\TransliteratorSlugTrait;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;

class SlugifyListener
{
    use TransliteratorSlugTrait;

    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();


    }

    public function preUpdate(PreUpdateEventArgs $args)
    {
        $entity = $args->getEntity();


    }
}
