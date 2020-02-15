<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EventRepository")
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="type", type="string")
 * @ORM\DiscriminatorMap({
 *     "base" = "Event",
 *     "lager" = "Lager",
 *     "tag" = "Tag",
 *     "sitzung" = "Sitzung",
 *     "programmpunkt" = "Programmpunkt",
 *     "teamzeit" = "Teamzeit",
 * })
 */
class Event
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateStart;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateEnd;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Programmpunkt", mappedBy="event")
     */
    private $programmpunkte;

    public function __construct()
    {
        $this->programmpunkte = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateStart(): ?\DateTimeInterface
    {
        return $this->dateStart;
    }

    public function setDateStart(\DateTimeInterface $dateStart): self
    {
        $this->dateStart = $dateStart;

        return $this;
    }

    public function getDateEnd(): ?\DateTimeInterface
    {
        return $this->dateEnd;
    }

    public function setDateEnd(\DateTimeInterface $dateEnd): self
    {
        $this->dateEnd = $dateEnd;

        return $this;
    }

    /**
     * @return Collection|Programmpunkt[]
     */
    public function getProgrammpunkte(): Collection
    {
        return $this->programmpunkte;
    }

    public function addProgrammpunkte(Programmpunkt $programmpunkte): self
    {
        if (!$this->programmpunkte->contains($programmpunkte)) {
            $this->programmpunkte[] = $programmpunkte;
            $programmpunkte->setEvent($this);
        }

        return $this;
    }

    public function removeProgrammpunkte(Programmpunkt $programmpunkte): self
    {
        if ($this->programmpunkte->contains($programmpunkte)) {
            $this->programmpunkte->removeElement($programmpunkte);
            // set the owning side to null (unless already changed)
            if ($programmpunkte->getEvent() === $this) {
                $programmpunkte->setEvent(null);
            }
        }

        return $this;
    }
}
