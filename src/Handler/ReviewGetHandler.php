<?php

namespace Tweave\ReviewApi\Handler;

use Tweave\ReviewApi\Helper\RatingHelper;
use Tweave\ReviewApi\Helper\ReviewHelper;

class ReviewGetHandler
{
    public function __construct(
        protected RatingHelper $ratingHelper,
        protected ReviewHelper $reviewHelper
    ) { }

    /**
     * @param  int  $id
     *
     * @return array
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function __invoke(int $id)
    {
        $review = $this->reviewHelper->getReview($id);

        $votesCollection = $this->ratingHelper->getReviewRatingVotes($review->getId(), $review->getStoreId());
        $value = null;
        if ( ! empty($votesCollection->getData()) && isset($votesCollection->getData()[0]['value'])) {
            $value = $votesCollection->getData()[0]['value'];
        }

        return [
            'id'         => $review->getId(),
            'title'      => $review->getTitle(),
            'detail'     => $review->getDetail(),
            'nickname'   => $review->getNickname(),
            'status'     => $review->getStatusId(),
            'customerId' => $review->getCustomerId(),
            'rating'     => $value
        ];
    }

}
