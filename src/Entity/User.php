<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use App\Controller\GetUserItinariesController;
use App\Controller\MeController;
use App\Controller\RegisterController;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Attribute\Groups;

#[ApiResource(operations: [
    new Post(
        uriTemplate: '/register',
        controller: RegisterController::class,
        name: 'register'
    ),
    new GetCollection(
        uriTemplate: '/me',
        controller: MeController::class,
        normalizationContext: ['groups' => ['user:read']],
    ),


])]
#[ORM\Entity(repositoryClass: UserRepository::class)]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['itinary:read','user:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    #[Groups(['itinary:read','user:read'])]
    private ?string $email = null;

    #[ORM\Column]
    #[Groups(['user:read'])]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;


    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Itinary::class, orphanRemoval: true)]
    private Collection $itinaries;


    public function __construct()
    {
        $this->itinaries = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string)$this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }


    /**
     * @return Collection<int, Itinary>
     */
    public function getItinaries(): Collection
    {
        return $this->itinaries;
    }

    public function addItinary(Itinary $itinary): static
    {
        if (!$this->itinaries->contains($itinary)) {
            $this->itinaries->add($itinary);
            $itinary->setUser($this);
        }

        return $this;
    }

    public function removeItinary(Itinary $itinary): static
    {
        if ($this->itinaries->removeElement($itinary)) {
            // set the owning side to null (unless already changed)
            if ($itinary->getUser() === $this) {
                $itinary->setUser(null);
            }
        }

        return $this;
    }


}
