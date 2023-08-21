<?php

namespace Tweave\ReviewApi\Handler;

use Magento\Review\Model\Review;
use Tweave\ReviewApi\Api\Data\ReviewDataInterface;
use Tweave\ReviewApi\Helper\CustomerHelper;
use Tweave\ReviewApi\Helper\ProductHelper;
use Tweave\ReviewApi\Helper\RatingHelper;
use Tweave\ReviewApi\Helper\ReviewHelper;

class ReviewCreateHandler
{
    public function __construct(
        protected CustomerHelper $customerHelper,
        protected ProductHelper $productHelper,
        protected RatingHelper $ratingHelper,
        protected ReviewHelper $reviewHelper
    ) { }

    /**
     * @param  ReviewDataInterface  $reviewData
     *
     * @return array[]
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function __invoke(ReviewDataInterface $reviewData): array
    {
        $review = $this->reviewHelper->initializeReview();
        $productId = $this->productHelper->getProductIdBySku($reviewData->getProductSku());
        $customer = $this->customerHelper->getCustomerByEmail($reviewData->getCustomerEmail(), $reviewData->getStoreId());
        $customerId = $this->customerHelper->getCustomerId($customer);
        $nickname = $this->customerHelper->getReviewNickname($customer, $reviewData->getCustomerName());

        if ($customer === null && empty($nickname)) {
            throw new \Magento\Framework\Exception\NoSuchEntityException(
                __("Customer details are missing. You either have an existent customer email or an customerName."));
        }

        $review->setEntityId($review->getEntityIdByCode(Review::ENTITY_PRODUCT_CODE))
            ->setEntityPkValue($productId)
            ->setStatusId($reviewData->getStatus())
            ->setCustomerId($customerId)
            ->setStoreId($reviewData->getStoreId())
            ->setStores([$reviewData->getStoreId()])
            ->setTitle($reviewData->getTitle())
            ->setDetail($reviewData->getContent())
            ->setNickname($nickname)
            ->save();

        $ratingValue = $reviewData->getRating();
        $this->ratingHelper->addReviewRatingVotes($ratingValue, (int) $review->getId(), $customerId, $productId);
        $review->aggregate();

        $votesCollection = $this->ratingHelper->getReviewRatingVotes((int) $review->getId(), $reviewData->getStoreId());
        $review->setData('rating_votes', $votesCollection);

        return [
            'id'         => $review->getId(),
            'title'      => $review->getTitle(),
            'detail'     => $review->getDetail(),
            'nickname'   => $review->getNickname(),
            'customerId' => $review->getCustomerId()
        ];
    }

}
