<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\AgencyRepository;
use Symfony\Component\Serializer\Annotation\Groups;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource(
 *     normalizationContext={"groups"={"agencies:read"}}
 * )
 * @ORM\Entity(repositoryClass=AgencyRepository::class)
 */
class Agency
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"agencies:read"})
     */
    private $name;

    /**
     * @ORM\Column(type="boolean")
     */
    private $is_dev;

    /**
     * @ORM\ManyToOne(targetEntity=Tpz::class, inversedBy="agencies")
     * @Groups({"agencies:read"})
     */
    private $tpz;

    /**
     * @ORM\OneToMany(targetEntity=User::class, mappedBy="agency")
     * @Groups({"agencies:read"})
     */
    private $users;

    /**
     * @ORM\OneToMany(targetEntity=Project::class, mappedBy="agency")
     * @Groups({"agencies:read", "users:read"})
     */
    private $projects;

    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->projects = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

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

    public function getTpz(): ?Tpz
    {
        return $this->tpz;
    }

    public function setTpz(?Tpz $tpz): self
    {
        $this->tpz = $tpz;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->setAgency($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getAgency() === $this) {
                $user->setAgency(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Project[]
     */
    public function getProjects(): Collection
    {
        return $this->projects;
    }

    public function addProject(Project $project): self
    {
        if (!$this->projects->contains($project)) {
            $this->projects[] = $project;
            $project->setAgency($this);
        }

        return $this;
    }

    public function removeProject(Project $project): self
    {
        if ($this->projects->removeElement($project)) {
            // set the owning side to null (unless already changed)
            if ($project->getAgency() === $this) {
                $project->setAgency(null);
            }
        }

        return $this;
    }
}
