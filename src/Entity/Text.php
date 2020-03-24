<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TextRepository")
 */
class Text
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
    * @ORM\Column(type="text")
     */
    private $content;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Article", inversedBy="texts")
     */
    private $article;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $articleOrder;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getArticle(): ?Article
    {
        return $this->article;
    }

    public function setArticle(?Article $article): self
    {
        $this->article = $article;

        return $this;
    }

    public function getArticleOrder(): ?int
    {
        return $this->articleOrder;
    }

    public function setArticleOrder(int $articleOrder): self
    {
        $this->articleOrder = $articleOrder;

        return $this;
    }
}
