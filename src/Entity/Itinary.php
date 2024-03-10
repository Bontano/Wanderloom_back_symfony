<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Controller\GetUserItinariesController;
use App\Controller\PostItinaryController;
use App\Controller\PutAddActivityController;
use App\Controller\PutFavoriteItinaryController;
use App\Repository\ItinaryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;


#[ApiResource(operations: [
    new Get(),
    new Post(
        uriTemplate: '/itinary/publication',
        controller: PostItinaryController::class,
        normalizationContext: ['groups' => ['itinary:read']],
        denormalizationContext: ['groups' => ['itinary:read']],
        name: 'newItinary'
    ),
    new Put(
        uriTemplate: '/itinary/{id}/favorite',
        controller: PutFavoriteItinaryController::class,
        normalizationContext: ['groups' => ['itinary:read']],
        denormalizationContext: ['groups' => ['itinary:read']],
        name: 'updateFavorite'
    ),
    new GetCollection(
        uriTemplate: '/itinary/user',
        controller: GetUserItinariesController::class,
        normalizationContext: ['groups' => ['itinary:read']],
        denormalizationContext: ['groups' => ['itinary:read']],
        name: 'getUserItinaries'
    ),
    new Get(
        uriTemplate: '/itinary/{id}',
        normalizationContext: ['groups' => ['itinary:read']],
        denormalizationContext: ['groups' => ['itinary:read']],
        name: 'getItinary'
    ),
    new Put(
        uriTemplate: '/itinary/{id}',
        normalizationContext: ['groups' => ['itinary:read']],
        denormalizationContext: ['groups' => ['itinary:read']],
        name: 'putItinary'
    ),
    new Put(
        uriTemplate: '/itinary/{id}/add/activity',
        controller: PutAddActivityController::class,
        normalizationContext: ['groups' => ['itinary:read']],
        denormalizationContext: ['groups' => ['itinary:read']],
        name: 'putActivityInItinary'
    ),
    new Put(
        uriTemplate: '/itinary/{id}/edit/activity',
        controller: GetUserItinariesController::class,
        normalizationContext: ['groups' => ['itinary:read']],
        denormalizationContext: ['groups' => ['itinary:read']],
        name: 'putActivityInItinary'
    )


])]
#[ORM\Entity(repositoryClass: ItinaryRepository::class)]
class Itinary
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['itinary:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['itinary:read'])]
    private ?string $title = null;

    #[ORM\Column(length: 255)]
    #[Groups(['itinary:read'])]
    private ?string $country = null;


    #[ORM\OneToMany(mappedBy: 'itinary', targetEntity: ItinaryActivity::class)]
    #[Groups(['itinary:read'])]
    private Collection $itinaryActivities;

    #[ORM\ManyToOne(inversedBy: 'itinaries')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\Column]
    #[Groups(['itinary:read'])]
    private ?bool $favorite = null;


    public function __construct()
    {
        $this->itinaryActivities = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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
            $itinaryActivity->setItinary($this);
        }

        return $this;
    }

    public function removeItinaryActivity(ItinaryActivity $itinaryActivity): static
    {
        if ($this->itinaryActivities->removeElement($itinaryActivity)) {
            // set the owning side to null (unless already changed)
            if ($itinaryActivity->getItinary() === $this) {
                $itinaryActivity->setItinary(null);
            }
        }

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

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
