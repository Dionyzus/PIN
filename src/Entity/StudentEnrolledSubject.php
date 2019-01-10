<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\StudentEnrolledSubjectRepository")
 */
class StudentEnrolledSubject
{
    /**
     * @ORM\Id()
     * @ORM\ManyToOne(targetEntity="App\Entity\User",inversedBy="studentEnrolledSubject")
     * @ORM\JoinColumn(name="user_id",referencedColumnName="id",nullable=false)
     */
    private $user;

    /**
     * @ORM\Id()
     * @ORM\ManyToOne(targetEntity="App\Entity\Subject",inversedBy="studentEnrolledSubject")
     * @ORM\JoinColumn(name="subject_id",referencedColumnName="id",nullable=false)
     */
    private $subject;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $status;

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getSubject(): ?Subject
    {
        return $this->subject;
    }

    public function setSubject(?Subject $subject): self
    {
        $this->subject = $subject;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }
}
