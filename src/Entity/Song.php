<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\RangeFilter;
use App\Repository\SongRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SongRepository::class)
 * @ApiResource(
 *  normalizationContext={"groups"={"outSong"}},
 *  collectionOperations={
 *      "get",
 *      "post"={"security"="is_granted('ROLE_USER')"}
 *  }
 * )
 * @ApiFilter(
 *  RangeFilter::class, properties={"id": "exact", "length"}
 * )
 */
#[ApiResource]
class Song
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"outSong"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"outSong"})
     */
    private $title;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"outSong"})
     */
    private $length;

    /**
     * @ORM\OneToOne(targetEntity=Album::class, inversedBy="song", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $album;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getLength(): ?int
    {
        return $this->length;
    }

    public function setLength(int $length): self
    {
        $this->length = $length;

        return $this;
    }

    public function getAlbum(): ?Album
    {
        return $this->album;
    }

    public function setAlbum(Album $album): self
    {
        $this->album = $album;

        return $this;
    }
}
