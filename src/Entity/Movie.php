<?php

namespace App\Entity;

use App\Repository\MovieRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MovieRepository::class)]
class Movie extends Media
{

    public function getMediaTypeString(): string
    {
        return 'movie';
    }
}
