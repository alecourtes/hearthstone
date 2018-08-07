<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\HearthstoneCardRepository")
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

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $attack;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $health;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $media;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $mediaGold;

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
        return $this->hearthstoneClass;
    }

    public function setHearthstoneClass(?HearthstoneClass $hearthstoneClass): self
    {
        $this->hearthstoneClass = $hearthstoneClass;

        return $this;
    }

    public function getHearthstoneSet(): ?HearthstoneSet
    {
        return $this->hearthstoneSet;
    }

    public function setHearthstoneSet(?HearthstoneSet $hearthstoneSet): self
    {
        $this->hearthstoneSet = $hearthstoneSet;

        return $this;
    }

    public function getAttack(): ?int
    {
        return $this->attack;
    }

    public function setAttack(?int $attack): self
    {
        $this->attack = $attack;

        return $this;
    }

    public function getHealth(): ?int
    {
        return $this->health;
    }

    public function setHealth(?int $health): self
    {
        $this->health = $health;

        return $this;
    }

    public function getMedia(): ?string
    {
        return $this->media;
    }

    public function setMedia(?string $media): self
    {
        $this->media = $media;

        return $this;
    }

    public function getMediaGold(): ?string
    {
        return $this->mediaGold;
    }

    public function setMediaGold(?string $mediaGold): self
    {
        $this->mediaGold = $mediaGold;

        return $this;
    }
}
