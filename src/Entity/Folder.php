<?php

namespace App\Entity;


use App\Entity\User;
use App\Repository\FolderRepository;
use Doctrine\ORM\Mapping as ORM;
#

#[ORM\Entity(repositoryClass: FolderRepository::class)]
class Folder
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\ManyToOne(inversedBy: 'folders')]
    private ?User $user = null;

    #[ORM\Column(length: 7)]
    private ?string $color = null;

    public function getColor(): ?string
    {
        return $this->color;
    }
    public function setColor(string $color): static
    {
        $this->color = $color;

        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }
    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

}
