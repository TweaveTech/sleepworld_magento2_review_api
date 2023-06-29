<?php

namespace Tweave\ReviewApi\Model;

use Tweave\ReviewApi\Api\Data\ReviewDataInterface;

class ReviewData implements ReviewDataInterface
{
    private $title;
    private $content;
    private $customerEmail;
    private $productSku;
    private $storeId;
    private $status;
    private $rating;
    private $customerName;

    public function getTitle()
    {
        return $this->title;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function getCustomerEmail()
    {
        return $this->customerEmail;
    }

    public function getProductSku()
    {
        return $this->productSku;
    }

    public function getStoreId()
    {
        return $this->storeId;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function getRating()
    {
        return $this->rating;
    }

    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    public function setContent($content)
    {
        $this->content = $content;
        return $this;
    }

    public function setCustomerEmail($email)
    {
        $this->customerEmail = $email;
        return $this;
    }

    public function setProductSku($sku)
    {
        $this->productSku = $sku;
        return $this;
    }

    public function setStoreId($storeId)
    {
        if ( ! is_array($storeId) && ! is_int($storeId)) {
            throw new \InvalidArgumentException('Store ID should be either an integer or an array of integers');
        }

        $this->storeId = $storeId;
        return $this;
    }


    public function setStatus($status)
    {
        $this->status = $status;
        return $this;
    }

    public function setRating($rating)
    {
        $this->rating = $rating;
        return $this;
    }

    public function getCustomerName()
    {
        return $this->customerName;
    }

    public function setCustomerName($name)
    {
        $this->customerName = $name;
        return $this;
    }
}
