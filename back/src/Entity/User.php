<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ApiResource(
 *     normalizationContext={"groups"={"users:read"}}
 * )
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     * @Groups({"users:read"})
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\ManyToOne(targetEntity=Agency::class, inversedBy="users")
     * @Groups({"users:read"})
     */
    private $agency;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"agencies:read"})
     * @Groups({"tpzMembers:read"})
     * @Groups({"users:read"})
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"agencies:read"})
     * @Groups({"tpzMembers:read"})
     * @Groups({"users:read"})
     */
    private $lastname;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"users:read"})
     */
    private $is_dev;

    /**
     * @ORM\ManyToMany(targetEntity=TpzRoles::class, inversedBy="users")
     * @Groups({"users:read"})
     */
    private $tpz_role;

    /**
     * @ORM\ManyToOne(targetEntity=Tpz::class, inversedBy="users")
     */
    private $tpz;

    public function __construct()
    {
        $this->tpz_role = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
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
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
     */
    public function getUsername(): string
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

    public function setRoles(array $roles): self
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

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }


    public function getAgency(): ?Agency
    {
        return $this->agency;
    }

    public function setAgency(?Agency $agency): self
    {
        $this->agency = $agency;

        return $this;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getIsDev(): ?bool
    {
        return $this->is_dev;
    }

    public function setIsDev(bool $is_dev): self
    {
        $this->is_dev = $is_dev;

        return $this;
    }

    /**
     * @return Collection|TpzRoles[]
     */
    public function getTpzRole(): Collection
    {
        return $this->tpz_role;
    }

    public function addTpzRole(TpzRoles $tpzRole): self
    {
        if (!$this->tpz_role->contains($tpzRole)) {
            $this->tpz_role[] = $tpzRole;
        }

        return $this;
    }

    public function removeTpzRole(TpzRoles $tpzRole): self
    {
        $this->tpz_role->removeElement($tpzRole);

        return $this;
    }

    public function getTpz(): ?Tpz
    {
        return $this->tpz;
    }

    public function setTpz(?Tpz $tpz): self
    {
        $this->tpz = $tpz;

        return $this;
    }
}
