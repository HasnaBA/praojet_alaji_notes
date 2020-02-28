<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ResultRepository")
 */
class Result
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="smallint", nullable=true)
     */
    private $test;

    /**
     * @ORM\Column(type="smallint", nullable=true)
     */
    private $interview;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Criteria", inversedBy="results")
     * @ORM\JoinColumn(nullable=false)
     */
    private $criteria;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Result", inversedBy="results")
     * @ORM\JoinColumn(nullable=false)
     */
    private $student;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Result", mappedBy="student")
     */
    private $results;

    public function __construct()
    {
        $this->results = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTest(): ?int
    {
        return $this->test;
    }

    public function setTest(?int $test): self
    {
        $this->test = $test;

        return $this;
    }

    public function getInterview(): ?int
    {
        return $this->interview;
    }

    public function setInterview(?int $interview): self
    {
        $this->interview = $interview;

        return $this;
    }

    public function getCriteria(): ?Criteria
    {
        return $this->criteria;
    }

    public function setCriteria(?Criteria $criteria): self
    {
        $this->criteria = $criteria;

        return $this;
    }

    public function getStudent(): ?self
    {
        return $this->student;
    }

    public function setStudent(?self $student): self
    {
        $this->student = $student;

        return $this;
    }

    /**
     * @return Collection|self[]
     */
    public function getResults(): Collection
    {
        return $this->results;
    }

    public function addResult(self $result): self
    {
        if (!$this->results->contains($result)) {
            $this->results[] = $result;
            $result->setStudent($this);
        }

        return $this;
    }

    public function removeResult(self $result): self
    {
        if ($this->results->contains($result)) {
            $this->results->removeElement($result);
            // set the owning side to null (unless already changed)
            if ($result->getStudent() === $this) {
                $result->setStudent(null);
            }
        }

        return $this;
    }
}