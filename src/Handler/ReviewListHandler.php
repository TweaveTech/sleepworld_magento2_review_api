<?php

namespace Tweave\ReviewApi\Handler;

use Tweave\ReviewApi\Helper\ProductHelper;
use Tweave\ReviewApi\Helper\RatingHelper;
use Tweave\ReviewApi\Helper\ReviewHelper;

class ReviewListHandler
{
    public function __construct(
        protected ProductHelper $productHelper,
        protected RatingHelper $ratingHelper,
        protected ReviewHelper $reviewHelper
    ) { }


    public function __invoke(string $productSku)
    {

        $productId = $this->productHelper->getProductIdBySku($productSku);

        if ( ! $productId) {
            throw new \Magento\Framework\Exception\NoSuchEntityException(__('No product with SKU: %1', $productSku));
        }

        $reviews = $this->reviewHelper->getReviewsByProductId($productId);
        $reviewsResponse = [];
        foreach ($reviews as $review) {

            $votesCollection = $this->ratingHelper->getReviewRatingVotes($review->getId(), $review->getStoreId());
            $value = null;
            if ( ! empty($votesCollection->getData()) && isset($votesCollection->getData()[0]['value'])) {
                $value = $votesCollection->getData()[0]['value'];
            }

            $reviewsResponse[] = [
                'id'         => $review->getId(),
                'nickname'   => $review->getNickname(),
                'title'      => $review->getTitle(),
                'detail'     => $review->getDetail(),
                'status'     => $review->getStatusId(),
                'customerId' => $review->getCustomerId(),
                'rating'     => $value
            ];
        }

        return $reviewsResponse;

    }

}
