<?php

namespace App\Model;

use Doctrine\ORM\EntityManagerInterface;

class Flusher
{
    public function __construct(private EntityManagerInterface $manager)
    {
    }

    public function flush(): void
    {
        $this->manager->flush();
    }
}