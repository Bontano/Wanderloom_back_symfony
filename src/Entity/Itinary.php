<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use App\Controller\GetUserItinariesController;
use App\Controller\ItineraireController;
use App\Repository\ItinaryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;


#[ApiResource(operations: [
    new Post(
        uriTemplate: '/itinary/publication',
        controller: ItineraireController::class,
        name: 'publication'
    ),
    new GetCollection(
        uriTemplate: '/itinary/user',
        controller: GetUserItinariesController::class,
        normalizationContext: ['groups' => ['itinary:read']],
        denormalizationContext: ['groups' => ['itinary:read']],
        name: 'getUserItinaries'
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

    #[ORM\OneToMany(mappedBy: 'itinary', targetEntity: UserItinary::class, orphanRemoval: true)]
    private Collection $userItinaries;

    #[ORM\OneToMany(mappedBy: 'itinary', targetEntity: ItinaryActivity::class)]
    #[Groups(['itinary:read'])]
    private Collection $itinaryActivities;


    public function __construct()
    {
        $this->userItinaries = new ArrayCollection();
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
     * @return Collection<int, UserItinary>
     */
    public function getUserItinaries(): Collection
    {
        return $this->userItinaries;
    }

    public function addUserItinary(UserItinary $userItinary): static
    {
        if (!$this->userItinaries->contains($userItinary)) {
            $this->userItinaries->add($userItinary);
            $userItinary->setItinary($this);
        }

        return $this;
    }

    public function removeUserItinary(UserItinary $userItinary): static
    {
        if ($this->userItinaries->removeElement($userItinary)) {
            // set the owning side to null (unless already changed)
            if ($userItinary->getItinary() === $this) {
                $userItinary->setItinary(null);
            }
        }

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
}
