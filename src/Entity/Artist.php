<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\RangeFilter;
use App\Repository\ArtistRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ArtistRepository::class)
 * @ApiResource(
 *  normalizationContext={"groups"={"outArtist"}},
 *  collectionOperations={
 *      "get",
 *      "post"={"security"="is_granted('ROLE_USER')"}
 *  }
 * )
 * @ApiFilter(
 *  SearchFilter::class, properties={"id": "exact", "style": "partial"}
 * )
 */
#[ApiResource]
class Artist
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"outArtist"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"outArtist"})
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"outArtist"})
     */
    private $style;

    /**
     * @ORM\OneToOne(targetEntity=Album::class, mappedBy="artist", cascade={"persist", "remove"})
     * @Groups({"outArtist"})
     */
    private $album;

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

    public function getStyle(): ?string
    {
        return $this->style;
    }

    public function setStyle(string $style): self
    {
        $this->style = $style;

        return $this;
    }

    public function getAlbum(): ?Album
    {
        return $this->album;
    }

    public function setAlbum(Album $album): self
    {
        // set the owning side of the relation if necessary
        if ($album->getArtist() !== $this) {
            $album->setArtist($this);
        }

        $this->album = $album;

        return $this;
    }
}
