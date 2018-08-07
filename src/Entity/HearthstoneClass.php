<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\HearthstoneClassRepository")
 */
class HearthstoneClass
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="HearthstoneCard", mappedBy="hearthstoneClass")
     */
    private $hearthstoneCards;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $code;

    public function __construct()
    {
        $this->hearthstoneCards = new ArrayCollection();
    }

    

    public function getId()
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

    /**
     * @return Collection|HearthstoneCard[]
     */
    public function getHearthstoneCards(): Collection
    {
        return $this->hearthstoneCards;
    }

    public function addHearthstoneCard(HearthstoneCard $hearthstoneCard): self
    {
        if (!$this->hearthstoneCards->contains($hearthstoneCard)) {
            $this->hearthstoneCards[] = $hearthstoneCard;
            $hearthstoneCard->setCategory($this);
        }

        return $this;
    }

    public function removeHearthstoneCard(HearthstoneCard $hearthstoneCard): self
    {
        if ($this->hearthstoneCards->contains($hearthstoneCard)) {
            $this->hearthstoneCards->removeElement($hearthstoneCard);
            // set the owning side to null (unless already changed)
            if ($hearthstoneCard->getCategory() === $this) {
                $hearthstoneCard->setCategory(null);
            }
        }

        return $this;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
    }
}
