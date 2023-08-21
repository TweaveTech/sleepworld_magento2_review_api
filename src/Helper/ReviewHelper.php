<?php

namespace Tweave\ReviewApi\Helper;

use Magento\Framework\App\ResourceConnection;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Review\Model\ResourceModel\Review\CollectionFactory;
use Magento\Review\Model\ReviewFactory;

class ReviewHelper
{
    /**
     * @var CollectionFactory
     */
    protected CollectionFactory $reviewCollectionFactory;

    /**
     * @var ReviewFactory
     */
    protected ReviewFactory $reviewFactory;

    /**
     * @var ResourceConnection
     */
    protected ResourceConnection $resourceConnection;

    public function __construct(
        ReviewFactory $reviewFactory,
        CollectionFactory $reviewCollectionFactory,
        ResourceConnection $resourceConnection
    ) {
        $this->reviewFactory = $reviewFactory;
        $this->reviewCollectionFactory = $reviewCollectionFactory;
        $this->resourceConnection = $resourceConnection;
    }

    /**
     * Get reviews by product ID
     *
     * @param  int  $productId
     *
     * @return array
     */
    public function getReviewsByProductId($productId): array
    {
        /** @var \Magento\Review\Model\ResourceModel\Review\Collection $reviewCollection */
        $reviewCollection = $this->reviewCollectionFactory->create();
        $reviewCollection
            ->addEntityFilter('product', $productId)
            ->setDateOrder();

        // You can apply additional filters or sorting as needed

        return $reviewCollection->getItems();
    }

    /**
     * Retrieves the review by its ID.
     *
     * @param int $id The ID of the review to retrieve.
     * @return \Magento\Review\Model\Review The loaded review.
     * @throws NoSuchEntityException If no review is found with the provided ID.
     */
    public function getReview(int $id): \Magento\Review\Model\Review
    {

        $review = $this->reviewFactory->create()->load($id);
        if ( ! $review->getId()) {
            throw new NoSuchEntityException(__('No such entity with id %1', $id));
        }

        return $review;
    }

    /**
     * Initializes a new review instance.
     *
     * @return \Magento\Review\Model\Review A new review instance.
     */
    public function initializeReview(): \Magento\Review\Model\Review
    {
        return $this->reviewFactory->create();
    }

    public function updateCustomerId($reviewId, $newCustomerId): array
    {
        try {
            $connection = $this->resourceConnection->getConnection();
            $tableName = $this->resourceConnection->getTableName('review_detail');

            $sql = "UPDATE $tableName SET customer_id = :new_customer_id WHERE review_id = :review_id";
            $bind = ['review_id' => $reviewId, 'new_customer_id' => $newCustomerId];
            $connection->query($sql, $bind);

            return ['success' => true, 'message' => 'Customer ID successfully updated.'];
        } catch (\Exception $e) {
            return ['success' => false, 'message' => 'Failed to update customer ID. Error: ' . $e->getMessage()];
        }
    }


}
