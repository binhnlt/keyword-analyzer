<?php

namespace App\Entity;

use Carbon\Carbon;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\KeywordReportRepository")
 */
class KeywordReport
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="bigint", options={"unsigned"=true})
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Keyword", inversedBy="reports")
     * @ORM\JoinColumn(name="keyword_id", referencedColumnName="id")
     */
    public $keyword;

    /**
     * @ORM\Column(type="bigint", options={"unsigned"=true})
     */
    private $keyword_id;

    /**
     * @ORM\Column(type="bigint")
     */
    private $adwords_number = 0;

    /**
     * @ORM\Column(type="bigint")
     */
    private $links_number = 0;

    /**
     * @ORM\Column(type="bigint")
     */
    private $result_num = 0;

    /**
     * @ORM\Column(type="float")
     */
    private $search_time = 0.0;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $source;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $page_content;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created_at;

    public function __construct()
    {
        $this->created_at = Carbon::now();
    }

    public function getId(): ?int
    {
        return $this->id;
    }


    public function getKeywordId(): ?int
    {
        return $this->keyword_id;
    }

    public function setKeywordId(int $keyword_id): self
    {
        $this->keyword_id = $keyword_id;

        return $this;
    }

    public function getAdwordsNumber(): ?int
    {
        return $this->adwords_number;
    }

    public function setAdwordsNumber(int $adwords_number): self
    {
        $this->adwords_number = $adwords_number;

        return $this;
    }

    public function getLinksNumber(): ?int
    {
        return $this->links_number;
    }

    public function setLinksNumber(int $links_number): self
    {
        $this->links_number = $links_number;

        return $this;
    }

    public function getResultNumber(): ?int
    {
        return $this->result_num;
    }

    public function setResultNumber(int $result_num): self
    {
        $this->result_num = $result_num;

        return $this;
    }

    public function getSearchTime(): ?float
    {
        return $this->search_time;
    }

    public function setSearchTime(float $search_time): self
    {
        $this->search_time = $search_time;

        return $this;
    }

    public function getSource(): ?string
    {
        return $this->source;
    }

    public function setSource(string $source): self
    {
        $this->source = $source;

        return $this;
    }

    public function getPageContent(): ?string
    {
        return $this->page_content;
    }

    public function setPageContent(?string $page_content): self
    {
        $this->page_content = $page_content;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function toData()
    {
        return [
            'id'             => $this->getId(),
            'created_at'     => $this->getCreatedAt()->format('Y-m-d H:i:s'),
            'adwords_number' => $this->getAdwordsNumber(),
            'links_number'   => $this->getLinksNumber(),
            'result_number'  => $this->getResultNumber(),
            'search_time'    => $this->getSearchTime(),
            'source'         => $this->getSource(),
        ];
    }
}
