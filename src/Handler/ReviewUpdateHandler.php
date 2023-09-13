<?php

namespace Tweave\ReviewApi\Handler;

use Tweave\ReviewApi\Api\Data\ReviewDataInterface;
use Tweave\ReviewApi\Helper\CustomerHelper;
use Tweave\ReviewApi\Helper\RatingHelper;
use Tweave\ReviewApi\Helper\ReviewHelper;

class ReviewUpdateHandler
{
    public function __construct(
        protected CustomerHelper $customerHelper,
        protected RatingHelper $ratingHelper,
        protected ReviewHelper $reviewHelper
    ) { }

    /**
     * @param  int  $id
     * @param  ReviewDataInterface  $reviewData
     *
     * @return array[]
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function __invoke(int $id, ReviewDataInterface $reviewData): array
    {

        $review = $this->reviewHelper->getReview($id);
        $productId = $review->getEntityId();
        $customer = $this->customerHelper->getCustomerByEmail($reviewData->getCustomerEmail(), $review->getStoreId());
        $customerId = $this->customerHelper->getCustomerId($customer);
        $nickname = $this->customerHelper->getReviewNickname($customer, $reviewData->getCustomerName());

        if ($customerId !== $review->getCustomerId()) {
            $review->setCustomerId($customerId);
            $this->reviewHelper->updateCustomerId($review->getId(), $customerId);
        }

        if ( ! empty($nickname) && $nickname !== $review->getNickname()) {
            $review->setNickname($nickname);
        }

        if ( ! empty($reviewData->getTitle()) && $reviewData->getTitle() !== $review->getTitle()) {
            $review->setTitle($reviewData->getTitle());
        }

        if ( ! empty($reviewData->getContent()) && $reviewData->getContent() !== $review->getDetail()) {
            $review->setDetail($reviewData->getContent());
        }

        if ( ! empty($reviewData->getStatus()) && $reviewData->getStatus() !== $review->getStatusId()) {
            $review->setStatusId($reviewData->getStatus());
        }

        if ( ! empty($reviewData->getCreatedAt()) && $reviewData->getCreatedAt() !== $review->getCreatedAt()) {
            $review->setCreatedAt($reviewData->getCreatedAt());
        }

        $review->save();

        $votesCollection = $this->ratingHelper->getReviewRatingVotes($review->getId(), $review->getStoreId());
        $currentRatingValue = $votesCollection->getData()[0]['value'];
        $newRatingValue = $reviewData->getRating();

        if ( ! empty($newRatingValue) && $currentRatingValue !== $newRatingValue) {
            $this->ratingHelper->updateReviewRatingVotes($newRatingValue, $id, $productId, $votesCollection, $review->getCustomerId());
        }

        $votesCollection = $this->ratingHelper->getReviewRatingVotes($review->getId(), $review->getStoreId());
        $value = null;
        if ( ! empty($votesCollection->getData()) && isset($votesCollection->getData()[0]['value'])) {
            $value = $votesCollection->getData()[0]['value'];
        }

        return [
            'id'         => $review->getId(),
            'title'      => $review->getTitle(),
            'nickname'   => $review->getNickname(),
            'detail'     => $review->getDetail(),
            'status'     => $review->getStatusId(),
            'customerId' => $review->getCustomerId(),
            'createdAt'  => $review->getCreatedAt(),
            'rating'     => $value
        ];
    }

}
