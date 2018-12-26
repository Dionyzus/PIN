<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SubjectRepository")
 */
class Subject
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=80)
     */
    private $subjectName;

    /**
     * @ORM\Column(type="string", length=16)
     */
    private $subjectKey;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $program;

    /**
     * @ORM\Column(type="integer")
     */
    private $ects;

    /**
     * @ORM\Column(type="integer")
     */
    private $semester_fullTimeStudent;

    /**
     * @ORM\Column(type="integer")
     */
    private $semester_partTimeStudent;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     */
    private $optionalSubject;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\StudentEnrolledSubject", mappedBy="subjectID")
     */
    private $studentEnrolledSubject;

    public function __construct()
    {
        $this->studentEnrolledSubject = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSubjectName(): ?string
    {
        return $this->subjectName;
    }

    public function setSubjectName(string $subjectName): self
    {
        $this->subjectName = $subjectName;

        return $this;
    }

    public function getSubjectKey(): ?string
    {
        return $this->subjectKey;
    }

    public function setSubjectKey(string $subjectKey): self
    {
        $this->subjectKey = $subjectKey;

        return $this;
    }

    public function getProgram(): ?string
    {
        return $this->program;
    }

    public function setProgram(string $program): self
    {
        $this->program = $program;

        return $this;
    }

    public function getEcts(): ?int
    {
        return $this->ects;
    }

    public function setEcts(int $ects): self
    {
        $this->ects = $ects;

        return $this;
    }

    public function getSemesterFullTimeStudent(): ?int
    {
        return $this->semester_fullTimeStudent;
    }

    public function setSemesterFullTimeStudent(int $semester_fullTimeStudent): self
    {
        $this->semester_fullTimeStudent = $semester_fullTimeStudent;

        return $this;
    }

    public function getSemesterPartTimeStudent(): ?int
    {
        return $this->semester_partTimeStudent;
    }

    public function setSemesterPartTimeStudent(int $semester_partTimeStudent): self
    {
        $this->semester_partTimeStudent = $semester_partTimeStudent;

        return $this;
    }

    public function getOptionalSubject(): ?string
    {
        return $this->optionalSubject;
    }

    public function setOptionalSubject(?string $optionalSubject): self
    {
        $this->optionalSubject = $optionalSubject;

        return $this;
    }
}
