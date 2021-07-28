<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=CategoryRepository::class)
 * @ApiResource()
 */
class Category
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\OneToMany(targetEntity=Fromage::class, mappedBy="category")
     */
    private $fromage;

    public function __construct()
    {
        $this->fromage = new ArrayCollection();
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection|Fromage[]
     */
    public function getFromage(): Collection
    {
        return $this->fromage;
    }

    public function addFromage(Fromage $fromage): self
    {
        if (!$this->fromage->contains($fromage)) {
            $this->fromage[] = $fromage;
            $fromage->setCategory($this);
        }

        return $this;
    }

    public function removeFromage(Fromage $fromage): self
    {
        if ($this->fromage->removeElement($fromage)) {
            // set the owning side to null (unless already changed)
            if ($fromage->getCategory() === $this) {
                $fromage->setCategory(null);
            }
        }

        return $this;
    }
}
