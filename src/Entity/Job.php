<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\JobRepository")
 */
class Job
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\JobType", inversedBy="jobs")
     * @ORM\JoinColumn(nullable=false)
     */
    private $jobType;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\CategoryType", inversedBy="jobs")
     * @ORM\JoinColumn(nullable=false)
     */
    private $categoryType;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Region", inversedBy="jobs")
     * @ORM\JoinColumn(nullable=false)
     */
    private $region;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="jobs")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $title;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="datetime")
     */
    private $jobDate;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isActive;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $jobUniqueId;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updatedAt;

    public function getId()
    {
        return $this->id;
    }

    public function getJobType(): ?JobType
    {
        return $this->jobType;
    }

    public function setJobType(?JobType $jobType): self
    {
        $this->jobType = $jobType;

        return $this;
    }

    public function getCategoryType(): ?CategoryType
    {
        return $this->categoryType;
    }

    public function setCategoryType(?CategoryType $categoryType): self
    {
        $this->categoryType = $categoryType;

        return $this;
    }

    public function getRegion(): ?Region
    {
        return $this->region;
    }

    public function setRegion(?Region $region): self
    {
        $this->region = $region;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getJobDate(): ?\DateTimeInterface
    {
        return $this->jobDate;
    }

    public function setJobDate(\DateTimeInterface $jobDate): self
    {
        $this->jobDate = $jobDate;

        return $this;
    }

    public function getIsActive(): ?bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): self
    {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getJobUniqueId()
    {
        return $this->jobUniqueId;
    }

    /**
     * @param mixed $jobUniqueId
     */
    public function setJobUniqueId($jobUniqueId): void
    {
        $this->jobUniqueId = $jobUniqueId;
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

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
}
