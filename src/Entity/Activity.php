<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use App\Controller\activity\DeleteActivityController;
use App\Controller\activity\PostNewActivityController;
use App\Repository\ActivityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ApiResource(operations: [
    new Get(),
    new Post(),
    new Post(
        uriTemplate: '/activity/generate',
        controller: PostNewActivityController::class,
        openapiContext: [
            'summary' => 'Route pour générer un itinéraire grâce à chatGPT',
            'requestBody' => [
                'content' => [
                    'application/json' => [
                        'schema' => [
                            'type' => 'object',
                            'properties' => [
                                'date' => [
                                    'type' => 'string',
                                    'example' => "19/03/2024",
                                ],
                                'dayMoment' => [
                                    'type' => 'string',
                                    'example' => 'Midi',
                                ],
                                'location' => [
                                    'type' => 'string',
                                    'example' => "Ecosse",
                                ],
                                'options' => [
                                    'type' => 'string',
                                    'example' => "Je veux un restaurant gastronomique",
                                ],
                            ],
                        ],
                        'example' => [
                            'date' => "19/03/2024",
                            'location' => 'Ecosse',
                            'dayMoment' => "Midi",
                            'options' => "Je veux un restaurant gastronomique",
                        ],
                    ],
                ],
            ],
        ],
        name: 'GenerateActivity',
    ),
    new Patch(
        denormalizationContext: ['groups' => ['activity:write']],
    ),
    new Delete(
        uriTemplate: '/activity/{id}/delete',
        controller: DeleteActivityController::class,
        name: 'DeleteActivity'
    ),
],
    normalizationContext: ['groups' => ['activity:read']],
    denormalizationContext: ['groups' => ['activity:write']],
)]
#[ORM\Entity(repositoryClass: ActivityRepository::class)]
class Activity
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;


    #[ORM\Column(type: Types::TEXT)]
    #[Groups(['itinary:read','activity:write','activity:read'])]
    private ?string $description = null;

    #[ORM\Column(length: 255)]
    #[Groups(['itinary:read','activity:read'])]
    private ?string $country = null;

    #[ORM\OneToMany(mappedBy: 'activity', targetEntity: ItinaryActivity::class)]
    #[Groups(['activity:read'])]
    private Collection $itinaryActivities;

    #[ORM\Column(length: 255)]
    #[Groups(['itinary:read','activity:write','activity:read'])]
    private ?string $title = null;

    #[ORM\Column]
    #[Groups(['itinary:read','activity:read'])]
    private ?float $latitude = null;

    #[ORM\Column]
    #[Groups(['itinary:read','activity:read'])]
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
