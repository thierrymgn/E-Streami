<?php

namespace App\Entity;

use App\Enum\CommentsStatusEnum;
use App\Repository\CommentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CommentRepository::class)]
class Comment
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $content = null;

    #[ORM\Column(enumType: CommentsStatusEnum::class)]
    private ?CommentsStatusEnum $status = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\ManyToOne(inversedBy: 'comments')]
    private ?User $author = null;

    #[ORM\ManyToOne(inversedBy: 'comments')]
    private ?Media $media = null;

    #[ORM\ManyToOne(targetEntity: self::class, inversedBy: 'parentComment')]
    private ?self $childComment = null;

    /**
     * @var Collection<int, self>
     */
    #[ORM\OneToMany(targetEntity: self::class, mappedBy: 'childComment')]
    private Collection $parentComment;

    public function __construct()
    {
        $this->parentComment = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): static
    {
        $this->content = $content;

        return $this;
    }

    public function getStatus(): ?CommentsStatusEnum
    {
        return $this->status;
    }

    public function setStatus(CommentsStatusEnum $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getAuthor(): ?User
    {
        return $this->author;
    }

    public function setAuthor(?User $author): static
    {
        $this->author = $author;

        return $this;
    }

    public function getMedia(): ?Media
    {
        return $this->media;
    }

    public function setMedia(?Media $media): static
    {
        $this->media = $media;

        return $this;
    }

    public function getChildComment(): ?self
    {
        return $this->childComment;
    }

    public function setChildComment(?self $childComment): static
    {
        $this->childComment = $childComment;

        return $this;
    }

    /**
     * @return Collection<int, self>
     */
    public function getParentComment(): Collection
    {
        return $this->parentComment;
    }

    public function addParentComment(self $parentComment): static
    {
        if (!$this->parentComment->contains($parentComment)) {
            $this->parentComment->add($parentComment);
            $parentComment->setChildComment($this);
        }

        return $this;
    }

    public function removeParentComment(self $parentComment): static
    {
        if ($this->parentComment->removeElement($parentComment)) {
            // set the owning side to null (unless already changed)
            if ($parentComment->getChildComment() === $this) {
                $parentComment->setChildComment(null);
            }
        }

        return $this;
    }
}
