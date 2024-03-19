<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\ItinaryActivityRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: ItinaryActivityRepository::class)]
class ItinaryActivity
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['itinary:read','activity:read'])]
    private ?int $id = null;

    #[ORM\ManyToOne(cascade: ['persisgkt'],inversedBy: 'itinaryActivities')]
    #[Groups(['itinary:read'])]
    private ?Activity $activity = null;

    #[ORM\ManyToOne(cascade: ['persist'], inversedBy: 'itinaryActivities')]
    #[Groups(['activity:read'])]
    #[ORM\JoinColumn(onDelete: "cascade")]
    private ?Itinary $itinary = null;

    #[ORM\Column(length: 255)]
    #[Groups(['itinary:read','activity:read'])]
    private ?string $dayMoment = null;

    #[ORM\Column(length: 255)]
    #[Groups(['itinary:read','activity:read'])]
    private ?string $day = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getActivity(): ?Activity
    {
        return $this->activity;
    }

    public function setActivity(?Activity $activity): static
    {
        $this->activity = $activity;

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

    public function getDayMoment(): ?string
    {
        return $this->dayMoment;
    }

    public function setDayMoment(string $dayMoment): static
    {
        $this->dayMoment = $dayMoment;

        return $this;
    }

    public function getDay(): ?string
    {
        return $this->day;
    }

    public function setDay(string $day): static
    {
        $this->day = $day;

        return $this;
    }
}
