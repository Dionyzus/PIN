<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use App\Entity\StudentEnrolledSubject;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @ORM\Table(name="user")
 * @UniqueEntity("email")
 * @UniqueEntity("username")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100, unique=true)
	 * @Assert\NotBlank()
     */
    private $username;

    /**
     * @ORM\Column(type="array")
     */
    private $roles;

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=100,unique=true)
	 * @Assert\Email()
     * @Assert\NotBlank()
     */
    private $email;

    /**
     * @Assert\NotBlank
     * @Assert\Length(max=4096)
     */
    private $plainPassword;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $status;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\StudentEnrolledSubject", mappedBy="user",orphanRemoval=true)
     */
    protected $studentEnrolledSubject;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $fullname;

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
            $studentEnrolledSubject->setUser($this);
        }

        return $this;
    }

    public function removeStudentSubject(StudentEnrolledSubject $studentEnrolledSubject): self
    {
        if ($this->studentEnrolledSubject->contains($studentEnrolledSubject)) {
            $this->studentEnrolledSubject->removeElement($studentEnrolledSubject);
            // set the owning side to null (unless already changed)
            if ($studentEnrolledSubject->getUser() === $this) {
                $studentEnrolledSubject->setUser(null);
            }
        }

        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    public function setPlainPassword($password)
    {
        $this->plainPassword = $password;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt():?string
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
		return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        $this->plainPassword = null;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

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

    public function getFullname(): ?string
    {
        return $this->fullname;
    }

    public function setFullname(string $fullname): self
    {
        $this->fullname = $fullname;

        return $this;
    }
    public function __toString()
    {
        return (string) $this->getUsername();
    }
}
