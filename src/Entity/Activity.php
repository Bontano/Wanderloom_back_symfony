<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Controller\GetUserItinariesController;
use App\Controller\PostItinaryController;
use App\Controller\PostNewActivityController;
use App\Controller\PutFavoriteItinaryController;
use App\Repository\ActivityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ApiResource(operations: [
    new Post(),
    new Put(),
    new Get(),
    new Delete(),
    new Post(
        uriTemplate: '/activity/generate',
        controller: PostNewActivityController::class,
        name: 'GenerateActivity'
    ),



])]
#[ORM\Entity(repositoryClass: ActivityRepository::class)]
class Activity
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;


    #[ORM\Column(type: Types::TEXT)]
    #[Groups(['itinary:read'])]
    private ?string $description = null;

    #[ORM\Column(length: 255)]
    #[Groups(['itinary:read'])]
    private ?string $country = null;

    #[ORM\OneToMany(mappedBy: 'activity', targetEntity: ItinaryActivity::class)]
    private Collection $itinaryActivities;

    #[ORM\Column(length: 255)]
    #[Groups(['itinary:read'])]
    private ?string $title = null;

    #[ORM\Column]
    #[Groups(['itinary:read'])]
    private ?float $latitude = null;

    #[ORM\Column]
    #[Groups(['itinary:read'])]
    private ?float $longitude = null;

    public function __construct()
    {
        $this->itinaryActivities = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }


    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(string $country): static
    {
        $this->country = $country;

        return $this;
    }

    /**
     * @return Collection<int, ItinaryActivity>
     */
    public function getItinaryActivities(): Collection
    {
        return $this->itinaryActivities;
    }

    public function addItinaryActivity(ItinaryActivity $itinaryActivity): static
    {
        if (!$this->itinaryActivities->contains($itinaryActivity)) {
            $this->itinaryActivities->add($itinaryActivity);
            $itinaryActivity->setActivity($this);
        }

        return $this;
    }

    public function removeItinaryActivity(ItinaryActivity $itinaryActivity): static
    {
        if ($this->itinaryActivities->removeElement($itinaryActivity)) {
            // set the owning side to null (unless already changed)
            if ($itinaryActivity->getActivity() === $this) {
                $itinaryActivity->setActivity(null);
            }
        }

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getLatitude(): ?float
    {
        return $this->latitude;
    }

    public function setLatitude(float $latitude): static
    {
        $this->latitude = $latitude;

        return $this;
    }

    public function getLongitude(): ?float
    {
        return $this->longitude;
    }

    public function setLongitude(float $longitude): static
    {
        $this->longitude = $longitude;

        return $this;
    }
}
