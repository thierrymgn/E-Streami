<?php

namespace App\Entity;

use App\Repository\PlaylistRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PlaylistRepository::class)]
class Playlist
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\ManyToOne(inversedBy: 'playlists')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $creator = null;

    /**
     * @var Collection<int, PlaylistSubscription>
     */
    #[ORM\OneToMany(targetEntity: PlaylistSubscription::class, mappedBy: 'playlist', orphanRemoval: true)]
    private Collection $playlistSubscriptions;

    /**
     * @var Collection<int, PlaylistMedia>
     */
    #[ORM\OneToMany(targetEntity: PlaylistMedia::class, mappedBy: 'playlist')]
    private Collection $playlistMedias;

    public function __construct()
    {
        $this->playlistSubscriptions = new ArrayCollection();
        $this->playlistMedias = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

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

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeImmutable $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getCreator(): ?User
    {
        return $this->creator;
    }

    public function setCreator(?User $creator): static
    {
        $this->creator = $creator;

        return $this;
    }

    /**
     * @return Collection<int, PlaylistSubscription>
     */
    public function getPlaylistSubscriptions(): Collection
    {
        return $this->playlistSubscriptions;
    }

    public function addPlaylistSubscription(PlaylistSubscription $playlistSubscription): static
    {
        if (!$this->playlistSubscriptions->contains($playlistSubscription)) {
            $this->playlistSubscriptions->add($playlistSubscription);
            $playlistSubscription->setPlaylist($this);
        }

        return $this;
    }

    public function removePlaylistSubscription(PlaylistSubscription $playlistSubscription): static
    {
        if ($this->playlistSubscriptions->removeElement($playlistSubscription)) {
            // set the owning side to null (unless already changed)
            if ($playlistSubscription->getPlaylist() === $this) {
                $playlistSubscription->setPlaylist(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, PlaylistMedia>
     */
    public function getPlaylistMedias(): Collection
    {
        return $this->playlistMedias;
    }

    public function addPlaylistMedia(PlaylistMedia $playlistMedia): static
    {
        if (!$this->playlistMedias->contains($playlistMedia)) {
            $this->playlistMedias->add($playlistMedia);
            $playlistMedia->setPlaylist($this);
        }

        return $this;
    }

    public function removePlaylistMedia(PlaylistMedia $playlistMedia): static
    {
        if ($this->playlistMedias->removeElement($playlistMedia)) {
            // set the owning side to null (unless already changed)
            if ($playlistMedia->getPlaylist() === $this) {
                $playlistMedia->setPlaylist(null);
            }
        }

        return $this;
    }

    public function getMediasTypeCount(): array
    {
        $mediaTypes = $this->playlistMedias->map(fn (PlaylistMedia $playlistMedia) => $playlistMedia->getMediaTypes())->toArray();
        $mediaTypes = array_merge(...$mediaTypes);
        $mediaTypesCount = array_count_values($mediaTypes);

        return $mediaTypesCount;
    }
}
