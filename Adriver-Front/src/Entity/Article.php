<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ArticleRepository")
 */
class Article implements \JsonSerializable
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer", unique=true)
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=128)
     */
    private ?string $title;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private ?string $leadingBody;
    
    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private ?string $body;
    
    /**
     * @ORM\Column(type="datetime")
     */
    private \DateTimeInterface $createdAt;
    
    /**
     * @ORM\Column(type="text")
     */
    private string $slug;
    
    /**
     * @ORM\Column(type="text")
     */
    private string $createdBy;
    
    public function __construct()
    {
        $this->createdAt = new \DateTime();
    }
    
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

    public function setBody(?string $body): self
    {
        $this->body = $body;

        return $this;
    }

    public function getCreatedAt(): \DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getCreatedBy(): ?string
    {
        return $this->createdBy;
    }

    public function setCreatedBy(string $createdBy): self
    {
        $this->createdBy = $createdBy;

        return $this;
    }

    public function getLeadingBody(): ?string
    {
        return $this->leadingBody;
    }

    public function setLeadingBody(?string $leadingBody): self
    {
        $this->leadingBody = $leadingBody;

        return $this;
    }
    
    public function jsonSerialize() 
    {
        return [
            'title' => $this->title,
            'leading_body' => $this->leadingBody,
            'body' => $this->body,
            'slug' => $this->slug,
            'created_by' => $this->createdBy
        ];
    }
}