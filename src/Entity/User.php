<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
class User
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    private ?string $password = null;

    #[ORM\Column(length: 255)]
    private ?string $roles = null;

    /**
     * @var Collection<int, Group>
     */
    #[ORM\OneToMany(targetEntity: Group::class, mappedBy: 'owner', orphanRemoval: true)]
    private Collection $ownedGroups;

    /**
     * @var Collection<int, Group>
     */
    #[ORM\ManyToMany(targetEntity: Group::class, mappedBy: 'members')]
    private Collection $groups;

    /**
     * @var Collection<int, Forum>
     */
    #[ORM\OneToMany(targetEntity: Forum::class, mappedBy: 'organisateur', orphanRemoval: true)]
    private Collection $forums;

    public function __construct()
    {
        $this->ownedGroups = new ArrayCollection();
        $this->groups = new ArrayCollection();
        $this->forums = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(string $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
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

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    public function getRoles(): ?string
    {
        return $this->roles;
    }

    public function setRoles(string $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @return Collection<int, Group>
     */
    public function getOwnedGroups(): Collection
    {
        return $this->ownedGroups;
    }

    public function addOwnedGroup(Group $ownedGroup): static
    {
        if (!$this->ownedGroups->contains($ownedGroup)) {
            $this->ownedGroups->add($ownedGroup);
            $ownedGroup->setOwner($this);
        }

        return $this;
    }

    public function removeOwnedGroup(Group $ownedGroup): static
    {
        if ($this->ownedGroups->removeElement($ownedGroup)) {
            // set the owning side to null (unless already changed)
            if ($ownedGroup->getOwner() === $this) {
                $ownedGroup->setOwner(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Group>
     */
    public function getGroups(): Collection
    {
        return $this->groups;
    }

    public function addGroup(Group $group): static
    {
        if (!$this->groups->contains($group)) {
            $this->groups->add($group);
            $group->addMember($this);
        }

        return $this;
    }

    public function removeGroup(Group $group): static
    {
        if ($this->groups->removeElement($group)) {
            $group->removeMember($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Forum>
     */
    public function getForums(): Collection
    {
        return $this->forums;
    }

    public function addForum(Forum $forum): static
    {
        if (!$this->forums->contains($forum)) {
            $this->forums->add($forum);
            $forum->setOrganisateur($this);
        }

        return $this;
    }

    public function removeForum(Forum $forum): static
    {
        if ($this->forums->removeElement($forum)) {
            // set the owning side to null (unless already changed)
            if ($forum->getOrganisateur() === $this) {
                $forum->setOrganisateur(null);
            }
        }

        return $this;
    }
}
