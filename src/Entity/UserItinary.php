<?php

namespace App\Entity;

use App\Repository\UserItinaryRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserItinaryRepository::class)]
class UserItinary
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(cascade: ['persist'],inversedBy: 'userItinaries')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $userCreator = null;

    #[ORM\ManyToOne(cascade: ['persist'],inversedBy: 'userItinaries')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Itinary $itinary = null;

    #[ORM\Column]
    private ?bool $favorite = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserCreator(): ?User
    {
        return $this->userCreator;
    }

    public function setUserCreator(?User $userCreator): static
    {
        $this->userCreator = $userCreator;

        return $this;
    }

    public function getItinary(): ?Itinary
    {
        return $this->itinary;
    }

    public function setItinary(?Itinary $itinary): static
    {
        $this->itinary = $itinary;

        return $this;
    }

    public function isFavorite(): ?bool
    {
        return $this->favorite;
    }

    public function setFavorite(bool $favorite): static
    {
        $this->favorite = $favorite;

        return $this;
    }
}
