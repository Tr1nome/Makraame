<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ItemRepository")
 */
class Item
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
    private $label;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Task", inversedBy="lists")
     */
    private $lists;

    /**
     * @ORM\Column(type="boolean")
     */
    private $filled;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(string $label): self
    {
        $this->label = $label;

        return $this;
    }

    public function getTask(): ?Task
    {
        return $this->lists;
    }

    public function setTask(?Task $lists): self
    {
        $this->lists = $lists;

        return $this;
    }

    public function __toString(){

        return $this->getLabel();
    }

    public function getFilled(): ?bool
    {
        return $this->filled;
    }

    public function setFilled(bool $filled): self
    {
        $this->filled = $filled;

        return $this;
    }

}
