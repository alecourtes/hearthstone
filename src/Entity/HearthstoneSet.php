<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\HearthstoneSetRepository")
 */
class HearthstoneSet
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
     * @ORM\OneToMany(targetEntity="App\Entity\HearthstoneCard", mappedBy="hearthstoneSet")
     */
    private $hearthstoneCards;

    public function __construct()
    {
        $this->cards = new ArrayCollection();
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
        return $this->cards;
    }

    public function addHearthstoneCard(HearthstoneCard $card): self
    {
        if (!$this->cards->contains($card)) {
            $this->cards[] = $card;
            $card->setHearthstoneExtension($this);
        }

        return $this;
    }

    public function removeHearthstoneCard(HearthstoneCard $card): self
    {
        if ($this->cards->contains($card)) {
            $this->cards->removeElement($card);
            // set the owning side to null (unless already changed)
            if ($card->getHearthstoneExtension() === $this) {
                $card->setHearthstoneExtension(null);
            }
        }

        return $this;
    }
}
