<?php

namespace App\Entity;

use App\Repository\StudentEnrolledSubjectRepository;
use Doctrine\Common\Collections\ArrayCollection;
use App\Entity\StudentEnrolledSubject;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass="App\Repository\SubjectRepository")
 * @UniqueEntity("subjectKey")
 * @UniqueEntity("subjectName")
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
     * @ORM\Column(type="string", length=80,unique=true)
     */
    private $subjectName;

    /**
     * @ORM\Column(type="string", length=16,unique=true)
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
     * @ORM\OneToMany(targetEntity="App\Entity\StudentEnrolledSubject", mappedBy="subject",orphanRemoval=true)
     */
    protected $studentEnrolledSubject;

    public function __construct()
    {
        $this->studentEnrolledSubject = new ArrayCollection();
    }

    /**
     * @return Collection|StudentEnrolledSubject[]
     */
    public function getStudentEnrolledSubject():Collection
    {
        return $this->studentEnrolledSubject;
    }
    public function addStudentSubject(StudentEnrolledSubject $studentEnrolledSubject): self
    {
        if (!$this->studentEnrolledSubject->contains($studentEnrolledSubject)) {
            $this->studentEnrolledSubject[] = $studentEnrolledSubject;
            $studentEnrolledSubject->setSubject($this);
        }

        return $this;
    }

    public function removeStudentSubject(StudentEnrolledSubject $studentEnrolledSubject): self
    {
        if ($this->studentEnrolledSubject->contains($studentEnrolledSubject)) {
            $this->studentEnrolledSubject->removeElement($studentEnrolledSubject);
            // set the owning side to null (unless already changed)
            if ($studentEnrolledSubject->getSubject() === $this) {
                $studentEnrolledSubject->setSubject(null);
            }
        }

        return $this;
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

    public function setEcts(?int $ects): self
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
    public function __toString()
    {
        return (string) $this->getSubjectName();
    }

}
