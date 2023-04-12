<?php

namespace App\Model\User\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Embeddable;
use Webmozart\Assert\Assert;

#[Embeddable]
class Name
{
    #[ORM\Column(type: 'string')]
    private string $first;

    #[ORM\Column(type: 'string')]
    private string $last;

    public function __construct(string $first, string $last)
    {
        Assert::notEmpty($first, 'First name must not be empty');
        Assert::notEmpty($last, 'Last name must not be empty');

        $this->first = $first;
        $this->last = $last;
    }

    public function fullName(): string
    {
        return $this->first . ' ' . $this->last;
    }

    public function getFirst(): string
    {
        return $this->first;
    }

    public function getLast(): string
    {
        return $this->last;
    }
}