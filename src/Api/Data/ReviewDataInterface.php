<?php

namespace Tweave\ReviewApi\Api\Data;

/**
 * Interface ReviewDataInterface
 *
 * @api
 */
interface ReviewDataInterface
{
    /**
     * @return string
     */
    public function getTitle(): string;

    /**
     * @return string
     */
    public function getContent(): string;

    /**
     * @return string
     */
    public function getProductSku(): string;

    /**
     * @return ?string
     */
    public function getCustomerEmail(): ?string;

    /**
     * @return int
     */
    public function getRating(): int;

    /**
     * @return int
     */
    public function getStoreId(): int;

    /**
     * @return int
     */
    public function getStatus(): int;

    /**
     * @return ?string
     */
    public function getCustomerName(): ?string;

    /**
     * @param  string  $title
     *
     * @return $this
     */
    public function setTitle(string $title): self;

    /**
     * @param  string  $content
     *
     * @return $this
     */
    public function setContent(string $content): self;

    /**
     * @param  string  $productSku
     *
     * @return $this
     */
    public function setProductSku(string $productSku): self;

    /**
     * @param ?string  $customerEmail
     *
     * @return $this
     */
    public function setCustomerEmail(?string $customerEmail): self;

    /**
     * @param  int  $rating
     *
     * @return $this
     */
    public function setRating(int $rating): self;

    /**
     * @param  int  $storeId
     *
     * @return $this
     */
    public function setStoreId(int $storeId): self;

    /**
     * @param  int  $status
     *
     * @return $this
     */
    public function setStatus(int $status): self;

    /**
     * @param  ?string  $customerName
     *
     * @return $this
     */
    public function setCustomerName(?string $customerName): self;
}
