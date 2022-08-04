<?php

namespace App\Entity;

use App\Repository\ContactRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ContactRepository::class)]
class Contact
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column()]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:"nom où pseudo requis")]
    #[Assert\Length(min : 2, max : 30)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:"email requis")]
    #[Assert\Email(message:"email invalide")]
    #[Assert\Length(min : 3, max : 50)]
    #[Assert\Regex(pattern:"/^[a-zA-Z0-9._-]+@[a-zA-Z0-9._-]+\.[a-zA-Z]{2,6}$/", message:"email invalide")]
    private ?string $email = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\NotBlank(message:"sujet requis")]
    #[Assert\Length(min : 2, max : 255)]
    private ?string $subject = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank(message:"message requis")]
    private ?string $message = null;

    public function getId(): ?int
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

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getSubject(): ?string
    {
        return $this->subject;
    }

    public function setSubject(?string $subject): self
    {
        $this->subject = $subject;

        return $this;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(string $message): self
    {
        $this->message = $message;

        return $this;
    }
}
