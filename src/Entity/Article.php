<?php

namespace App\Entity;

use App\Repository\ArticleRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ArticleRepository::class)
 */
class Article
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="text")
     */
    private $body;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="articles")
     * @ORM\JoinColumn(nullable=false)
     */
    private $author;

    /**
     * @Assert\Image(
     *     maxHeight="100",
     *     maxWidth="100",
     *     maxHeightMessage="Please provide an image with max height 100px",
     *     maxWidthMessage="Please provide an image with max  width 100px",
     *     mimeTypes={"image/png", "image/jpeg"},
     *     mimeTypesMessage="Please provide a valid type: only JPEG and PNG allowed"
     * )
     *
     */
    private $cover;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $articleCover;

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

    public function getBody(): ?string
    {
        return $this->body;
    }

    public function setBody(string $body): self
    {
        $this->body = $body;

        return $this;
    }

    public function getAuthor(): ?UserInterface
    {
        return $this->author;
    }

    public function setAuthor(?UserInterface $author): self
    {
        $this->author = $author;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getCover()
    {
        return $this->cover;
    }

    /**
     * @param mixed $cover
     *
     * @return Article
     */
    public function setCover($cover): self
    {
        $this->cover = $cover;

        return $this;
    }

    public function getArticleCover(): ?string
    {
        return $this->articleCover;
    }

    public function setArticleCover($articleCover): self
    {
        $this->articleCover = $articleCover;

        return $this;
    }
}
