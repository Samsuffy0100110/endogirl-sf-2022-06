<?php

namespace App\Entity;

use DateTime;
use Serializable;
use App\Entity\Forum\Reply;
use App\Entity\Forum\Topic;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\HttpFoundation\File\File;
use Doctrine\Common\Collections\ArrayCollection;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[UniqueEntity(fields: ['email'], message: 'Il y à déjà un compte associé à cette adresse email.')]
#[Vich\Uploadable]
/**
 * This will suppress all the PMD warnings in
 * this class.
 *
 * @SuppressWarnings(PHPMD)
 */
class User implements UserInterface, PasswordAuthenticatedUserInterface, Serializable
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column()]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    #[Assert\Length(min : 3, max : 50)]
    #[Assert\NotBlank(message:"email requis")]
    private ?string $email = null;

    #[ORM\Column]
    private array $roles = [];

    private ?string $plainPassword = null;

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank()]
    #[Assert\Length(min : 3, max : 50)]
    private ?string $nickname = null;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Comment::class)]
    private Collection $comments;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Topic::class)]
    private Collection $topics;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Reply::class)]
    private Collection $reply;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $avatar = 'default.png';

    #[Vich\UploadableField(mapping: 'pictures', fileNameProperty: 'avatar')]
    #[Assert\Image(
        mimeTypes: ["image/jpeg", "image/png"],
        maxSize: "2M",
        maxSizeMessage: "L'image ne doit pas dépasser 2Mo"
    )]
    private ?File $avatarFile = null;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private ?DateTime $updatedAt = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $biography = null;

    #[ORM\Column(nullable: true)]
    private ?bool $isVerified = null;

    public function __construct()
    {
        $this->comments = new ArrayCollection();
        $this->topics = new ArrayCollection();
        $this->reply = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
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

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;
        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getNickname(): ?string
    {
        return $this->nickname;
    }

    public function setNickname(string $nickname): self
    {
        $this->nickname = $nickname;
        return $this;
    }

    /**
     * @return Collection<int, Comment>
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments[] = $comment;
            $comment->setUser($this);
        }
        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getUser() === $this) {
                $comment->setUser(null);
            }
        }
        return $this;
    }

    public function __toString(): string
    {
        return $this->nickname;
    }

    /**
     * Get the value of plainPassword
     */
    public function getPlainPassword(): ?string
    {
        return $this->plainPassword;
    }

    /**
     * Set the value of plainPassword
     *
     * @return self
     */
    public function setPlainPassword(?string $plainPassword)
    {
        $this->plainPassword = $plainPassword;
        return $this;
    }

    /**
     * @return Collection<int, Topic>
     */
    public function getTopics(): Collection
    {
        return $this->topics;
    }

    public function addTopic(Topic $topic): self
    {
        if (!$this->topics->contains($topic)) {
            $this->topics[] = $topic;
            $topic->setUser($this);
        }
        return $this;
    }

    public function removeTopic(Topic $topic): self
    {
        if ($this->topics->removeElement($topic)) {
            // set the owning side to null (unless already changed)
            if ($topic->getUser() === $this) {
                $topic->setUser(null);
            }
        }
        return $this;
    }

    /**
     * @return Collection<int, Reply>
     */
    public function getReply(): Collection
    {
        return $this->reply;
    }

    public function addReply(Reply $reply): self
    {
        if (!$this->reply->contains($reply)) {
            $this->reply[] = $reply;
            $reply->setUser($this);
        }
        return $this;
    }

    public function removeReply(Reply $reply): self
    {
        if ($this->reply->removeElement($reply)) {
            // set the owning side to null (unless already changed)
            if ($reply->getUser() === $this) {
                $reply->setUser(null);
            }
        }
        return $this;
    }

    public function getAvatar(): ?string
    {
        return $this->avatar;
    }

    public function setAvatar(?string $avatar): self
    {
        $this->avatar = $avatar;
        return $this;
    }

    /**
     * Get the value of imageFile
     */
    public function getAvatarFile(): ?File
    {
        return $this->avatarFile;
    }

    /**
     * Set the value of imageFile
     *
     * @return self
     */
    public function setAvatarFile(File $avatar = null)
    {
        $this->avatarFile = $avatar;
        if ($avatar) {
            $this->updatedAt = new DateTime('now');
        }
        return $this;
    }

    public function serialize()
    {
        return serialize(
            array(
            $this->id,
            $this->email,
            $this->password,
            $this->nickname,
            $this->avatar,
            // see section on salt below
            // $this->salt,
            )
        );
    }

    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->email,
            $this->password,
            $this->nickname,
            $this->avatar,
            // see section on salt below
            // $this->salt
        ) = unserialize($serialized);
    }
    /**
     * Get the value of updatedAt
     */
    public function getUpdatedAt(): ?DateTime
    {
        return $this->updatedAt;
    }

    /**
     * Set the value of updatedAt
     *
     * @return self
     */
    public function setUpdatedAt(DateTime $updatedAt): self
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    public function getBiography(): ?string
    {
        return $this->biography;
    }

    public function setBiography(?string $biography): self
    {
        $this->biography = $biography;
        return $this;
    }

    public function isIsVerified(): ?bool
    {
        return $this->isVerified;
    }

    public function setIsVerified(?bool $isVerified): self
    {
        $this->isVerified = $isVerified;
        return $this;
    }
}
