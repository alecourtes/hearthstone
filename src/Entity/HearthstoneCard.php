<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CardsRepository")
 */
class HearthstoneCard
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
    private $cardId;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity="HearthstoneClass", inversedBy="hearthstoneCards")
     * @ORM\JoinColumn(nullable=false)
     */
    private $hearthstoneClass;

    /**
     * @ORM\ManyToOne(targetEntity="HearthstoneSet", inversedBy="hearthstoneCards")
     * @ORM\JoinColumn(nullable=false)
     */
    private $hearthstoneSet;

    public function getId()
    {
        return $this->id;
    }

    public function getCardId(): ?string
    {
        return $this->cardId;
    }

    public function setCardId(string $cardId): self
    {
        $this->cardId = $cardId;

        return $this;
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

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getHearthstoneClass(): ?HearthstoneClass
    {
        return $this->category;
    }

    public function setHearthstoneClass(?HearthstoneClass $hearthstoneClass): self
    {
        $this->hearthstoneClass = $category;

        return $this;
    }

    public function getHearthstoneSet(): ?HearthstoneSet
    {
        return $this->hearthstoneExtension;
    }

    public function setHearthstoneSet(?HearthstoneSet $hearthstoneExtension): self
    {
        $this->hearthstoneExtension = $hearthstoneExtension;

        return $this;
    }
}
