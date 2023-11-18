<?php

namespace DoctrineExtensions\Tests\Entities;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
final class Date
{
    #[ORM\Id]
    #[ORM\Column]
    #[ORM\GeneratedValue]
    public string $id;

    #[ORM\Column]
    public \DateTime $created;
}
