<?php

namespace Tweave\ReviewApi\Helper;

use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Customer\Model\CustomerRegistry;
use Magento\Review\Model\Rating;
use Magento\Review\Model\Rating\OptionFactory;
use Magento\Review\Model\RatingFactory;
use Magento\Review\Model\ResourceModel\Rating\Option\Vote\Collection as OptionVoteCollection;
use Magento\Review\Model\ResourceModel\Rating\Option\Vote\CollectionFactory as OptionVoteCollectionFactory;
use Magento\Store\Api\StoreRepositoryInterface;
use Tweave\ReviewApi\Model\Config;

class RatingHelper
{
    /**
     * @var RatingFactory
     */
    protected RatingFactory $ratingFactory;

    /**
     * @var OptionVoteCollectionFactory
     */
    protected OptionVoteCollectionFactory $ratingOptionCollectionFactory;

    /**
     * @var OptionFactory
     */
    protected OptionFactory $ratingOptionModelFactory;

    /**
     * @var Config
     */
    protected Config $config;

    /**
     * @param  CustomerRepositoryInterface  $customerRepository
     * @param  CustomerRegistry  $customerRegistry
     * @param  StoreRepositoryInterface  $storeRepository
     */
    public function __construct(
        RatingFactory $ratingFactory,
        OptionVoteCollectionFactory $ratingOptionCollectionFactory,
        OptionFactory $ratingOptionModelFactory,
        Config $config,
    ) {
        $this->ratingFactory = $ratingFactory;
        $this->ratingOptionCollectionFactory = $ratingOptionCollectionFactory;
        $this->ratingOptionModelFactory = $ratingOptionModelFactory;
        $this->config = $config;
    }

    /**
     * Get rating option ID
     *
     * @param  int  $ratingId  Rating ID.
     * @param  int  $value  Value of the option.
     *
     * @return int|null
     */
    public function getOptionIdByRatingIdAndValue(int $ratingId, int $value): ?int
    {
        /** @var \Magento\Review\Model\Rating\Option $ratingOptionModel */
        $ratingOptionModel = $this->ratingOptionModelFactory->create();

        $ratingOption = $ratingOptionModel->getCollection()
            ->addFieldToFilter('rating_id', $ratingId)
            ->addFieldToFilter('value', $value)
            ->getFirstItem();

        if ($ratingOption->getId()) {
            return (int) $ratingOption->getId();
        }

        return null;
    }


    /**
     * @param  int  $rating
     * @param  int  $reviewId
     * @param  int|null  $customerId
     * @param  int  $productId
     *
     * @return void
     * @throws \Exception
     */
    public function addReviewRatingVotes(int $rating, int $reviewId, ?int $customerId, int $productId): void
    {
        $ratingId = $this->config->getRatingId();
        $optionId = $this->getOptionIdByRatingIdAndValue($ratingId, $rating);

        if ($optionId === null) {
            throw new \Exception(sprintf('No option found for ratingId %d and value %d', $ratingId, $rating));
        }

        /** @var Rating $ratingModel */
        $ratingModel = $this->ratingFactory->create();
        $ratingModel
            ->setRatingId($ratingId)
            ->setReviewId($reviewId)
            ->setCustomerId($customerId)
            ->addOptionVote($optionId, $productId);
    }

    /**
     * Get review rating votes
     *
     * @param  int  $reviewId
     * @param  int  $storeId
     *
     * @return OptionVoteCollection
     */
    public function getReviewRatingVotes(int $reviewId, int $storeId): OptionVoteCollection
    {
        /** @var OptionVoteCollection $votesCollection */
        $votesCollection = $this->ratingOptionCollectionFactory->create();
        $votesCollection->setReviewFilter($reviewId)->setStoreFilter($storeId)->addRatingInfo($storeId);

        return $votesCollection;
    }

    public function updateReviewRatingVotes(int $newRatingValue, int $reviewId, int $productId, $votesCollection, ?int $customerId,): void
    {
        $ratingId = $this->config->getRatingId();
        $optionId = $this->getOptionIdByRatingIdAndValue($ratingId, $newRatingValue);

        if ($optionId === null) {
            throw new \Exception(sprintf('No option found for ratingId %d and value %d', $ratingId, $newRatingValue));
        }

        if ($votesCollection->getSize() > 0) {
            $vote = $votesCollection->getFirstItem();
            $vote->setValue($newRatingValue)
                ->setPercent($newRatingValue * 20)
                ->setOptionId($optionId)
                ->save();
        } else {
            /** @var Rating $ratingModel */
            $ratingModel = $this->ratingFactory->create();
            $ratingModel
                ->setRatingId($ratingId)
                ->setReviewId($reviewId)
                ->setCustomerId($customerId)
                ->addOptionVote($optionId, $productId);
        }
    }

}
