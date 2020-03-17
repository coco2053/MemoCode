<?php

namespace App\Entity;

use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ArticleRepository")
 * @UniqueEntity(
 * fields= {"title"},
 * message= "Une article du même titre existe déjà!")
 */
class Article
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(min="3", minMessage="Le titre doit contenir au moins 3 caractères !")
     * @Assert\Length(max="50", minMessage="Le titre ne doit contenir plus de 50 caractères !")
     */
    private $title;

    /**
    * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Text", mappedBy="article", cascade={"persist", "remove"}, orphanRemoval=true)
     */
    private $texts;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Memo", mappedBy="article", cascade={"persist", "remove"}, orphanRemoval=true)
     */
    private $memos;

    public function __construct()
    {
        $this->texts = new ArrayCollection();
        $this->memos = new ArrayCollection();
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return Collection|Text[]
     */
    public function getTexts(): Collection
    {
        return $this->texts;
    }

    public function addText(Text $text): self
    {
        if (!$this->texts->contains($text)) {
            $this->texts[] = $text;
            $text->setArticle($this);
        }

        return $this;
    }

    public function removeText(Text $text): self
    {
        if ($this->texts->contains($text)) {
            $this->texts->removeElement($text);
            // set the owning side to null (unless already changed)
            if ($text->getArticle() === $this) {
                $text->setArticle(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Memo[]
     */
    public function getMemos(): Collection
    {
        return $this->memos;
    }

    public function addMemo(Memo $memo): self
    {
        if (!$this->memos->contains($memo)) {
            $this->memos[] = $memo;
            $memo->setArticle($this);
        }

        return $this;
    }

    public function removeMemo(Memo $memo): self
    {
        if ($this->memos->contains($memo)) {
            $this->memos->removeElement($memo);
            // set the owning side to null (unless already changed)
            if ($memo->getArticle() === $this) {
                $memo->setArticle(null);
            }
        }

        return $this;
    }
}
