<?php

namespace Tweave\ReviewApi\Model;

use Tweave\ReviewApi\Api\Data\ReviewDataInterface;

class ReviewData implements ReviewDataInterface
{
    private ?string $title = null;
    private ?string $content = null;
    private ?string $productSku = null;
    private ?int $storeId = null;
    private ?int $status = null;
    private ?int $rating = null;
    private ?string $customerEmail = null;
    private ?string $customerName = null;
    private ?string $createdAt = null;

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function getCustomerEmail(): ?string
    {
        return $this->customerEmail;
    }

    public function getProductSku(): ?string
    {
        return $this->productSku;
    }

    public function getStoreId(): ?int
    {
        return $this->storeId;
    }

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function getRating(): ?int
    {
        return $this->rating;
    }

    public function getCustomerName(): ?string
    {
        return $this->customerName;
    }

    public function getCreatedAt(): ?string
    {
        return $this->createdAt;
    }

    public function setTitle(?string $title): ReviewDataInterface
    {
        $this->title = $title;
        return $this;
    }

    public function setContent(?string $content): ReviewDataInterface
    {
        $this->content = $content;
        return $this;
    }

    public function setCustomerEmail(?string $customerEmail): ReviewDataInterface
    {
        $this->customerEmail = $customerEmail;
        return $this;
    }

    public function setProductSku(?string $productSku): ReviewDataInterface
    {
        $this->productSku = $productSku;
        return $this;
    }


    public function setStoreId(?int $storeId): ReviewDataInterface
    {
        if (!is_null($storeId) && !is_int($storeId)) {
            throw new \InvalidArgumentException('Store ID should be either an integer or null');
        }

        $this->storeId = $storeId;
        return $this;
    }


    public function setStatus(?int $status): ReviewDataInterface
    {
        $this->status = $status;
        return $this;
    }

    public function setRating(?int $rating): ReviewDataInterface
    {
        $this->rating = $rating;
        return $this;
    }

    public function setCustomerName(?string $customerName): ReviewDataInterface
    {
        $this->customerName = $customerName;
        return $this;
    }

    public function setCreatedAt(?string $createdAt): ReviewDataInterface
    {
        $this->createdAt = $createdAt;
        return $this;
    }
}
