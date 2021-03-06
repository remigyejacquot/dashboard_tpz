<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ProjectRepository;
use Symfony\Component\Serializer\Annotation\Groups;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=ProjectRepository::class)
 */
class Project
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"tpzs:read","agencies:read"})
     */
    private $name;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $created_at;

    /**
     * @ORM\Column(type="datetime_immutable")
     * @Groups({"agencies:read", "tpzs:read"})
     */
    private $updated_at;

    /**
     * @ORM\ManyToOne(targetEntity=Agency::class, inversedBy="projects")
     */
    private $agency;

    /**
     * @ORM\OneToMany(targetEntity=Task::class, mappedBy="project", cascade={"persist", "remove"})
     * @Groups({"agencies:read"})
     */
    private $tasks;

    public function __construct()
    {
        $this->tasks = new ArrayCollection();
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

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(\DateTimeImmutable $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
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

    /**
     * @return Collection|Task[]
     */
    public function getTasks(): Collection
    {
        return $this->tasks;
    }

    public function addTask(Task $task): self
    {
        if (!$this->tasks->contains($task)) {
            $this->tasks[] = $task;
            $task->setProject($this);
        }

        return $this;
    }

    public function removeTask(Task $task): self
    {
        if ($this->tasks->removeElement($task)) {
            // set the owning side to null (unless already changed)
            if ($task->getProject() === $this) {
                $task->setProject(null);
            }
        }

        return $this;
    }

    /**
     *  @Groups({"tpzs:read"})
     */
    public function getLastTasks() {
        $lastTasks = null;
        if(count($this->tasks) === 1)
            $lastTasks = $this->tasks->last();
        else if (count($this->tasks) >= 2)
            $lastTasks = $this->tasks->slice(-2, 2);
        return $lastTasks;
    }

    /**
     *  @Groups({"tpzs:read"})
     */
    public function getAvancementNumber() {
        $tasks = $this->getTasks();
        $count = 0;
        /** @var Task $task */
        foreach($tasks as $task) {
            if($task->getFinishedAt()) {
                $count++;
            }
        }
        if($count > 0) {
            return ($count/count($tasks)*100);
        }
        return 0;
    }

}
