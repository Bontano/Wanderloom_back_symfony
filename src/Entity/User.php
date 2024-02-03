<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Post;
use App\Controller\RegisterController;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ApiResource(operations: [
    new Post(
        uriTemplate: '/register',
        controller: RegisterController::class,
        name: 'register'
    )
])]
#[ORM\Entity(repositoryClass: UserRepository::class)]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $email = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(length: 255)]
    private ?string $username = null;

    #[ORM\OneToMany(mappedBy: 'userCreator', targetEntity: Itinary::class, orphanRemoval: true)]
    private Collection $itinaries;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Itinary::class)]
    private Collection $favoriteItinaries;

    public function __construct()
    {
        $this->itinaries = new ArrayCollection();
        $this->favoriteItinaries = new ArrayCollection();
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
        return (string) $this->email;
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

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): static
    {
        $this->username = $username;

        return $this;
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
            $itinary->setUserCreator($this);
        }

        return $this;
    }

    public function removeItinary(Itinary $itinary): static
    {
        if ($this->itinaries->removeElement($itinary)) {
            // set the owning side to null (unless already changed)
            if ($itinary->getUserCreator() === $this) {
                $itinary->setUserCreator(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Itinary>
     */
    public function getFavoriteItinaries(): Collection
    {
        return $this->favoriteItinaries;
    }

    public function addFavoriteItinary(Itinary $favoriteItinary): static
    {
        if (!$this->favoriteItinaries->contains($favoriteItinary)) {
            $this->favoriteItinaries->add($favoriteItinary);
            $favoriteItinary->setUser($this);
        }

        return $this;
    }

    public function removeFavoriteItinary(Itinary $favoriteItinary): static
    {
        if ($this->favoriteItinaries->removeElement($favoriteItinary)) {
            // set the owning side to null (unless already changed)
            if ($favoriteItinary->getUser() === $this) {
                $favoriteItinary->setUser(null);
            }
        }

        return $this;
    }
}
