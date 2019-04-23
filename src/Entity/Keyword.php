<?php

namespace App\Entity;

use Carbon\Carbon;
use App\Entity\KeywordReport;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass="App\Repository\KeywordRepository")
 */
class Keyword
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="bigint", options={"unsigned"=true})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, options={"unique"=true})
     */
    private $keyword;

    /**
     * @ORM\OneToMany(targetEntity="KeywordReport", mappedBy="keyword", fetch="EXTRA_LAZY", orphanRemoval=true, cascade={"persist"})
     */
    public $reports;

    /**
     * @ORM\Column(type="datetime")
     */
    private $imported_at;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updated_at;

    public function __construct()
    {
        $this->reports = new ArrayCollection();
        $this->imported_at = Carbon::now();
        $this->updated_at = Carbon::now();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getKeyword(): ?string
    {
        return $this->keyword;
    }

    public function setKeyword(string $keyword): self
    {
        $this->keyword = $keyword;

        return $this;
    }

    public function getImportedAt(): ?\DateTimeInterface
    {
        return $this->imported_at;
    }

    public function setImportedAt(\DateTimeInterface $imported_at): self
    {
        $this->imported_at = $imported_at;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(\DateTimeInterface $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }
}
