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
    public function getTitle();

    /**
     * @return string
     */
    public function getContent();

    /**
     * @return string
     */
    public function getProductSku();

    /**
     * @return string
     */
    public function getCustomerEmail();

    /**
     * @return int
     */
    public function getRating();

    /**
     * @return int
     */
    public function getStoreId();

    /**
     * @return int
     */
    public function getStatus();

    /**
     * @param  string  $title
     *
     * @return $this
     */
    public function setTitle($title);

    /**
     * @param  string  $content
     *
     * @return $this
     */
    public function setContent($content);

    /**
     * @param  string  $productSku
     *
     * @return $this
     */
    public function setProductSku($productSku);

    /**
     * @param  string  $customerEmail
     *
     * @return $this
     */
    public function setCustomerEmail($customerEmail);

    /**
     * @param  int  $rating
     *
     * @return $this
     */
    public function setRating($rating);

    /**
     * @param  int  $storeId
     *
     * @return $this
     */
    public function setStoreId($storeId);

    /**
     * @param  int  $status
     *
     * @return $this
     */
    public function setStatus($status);

    /**
     * @return string
     */
    public function getCustomerName();

    /**
     * @param  string  $customerName
     *
     * @return $this
     */
    public function setCustomerName($customerName);
}
