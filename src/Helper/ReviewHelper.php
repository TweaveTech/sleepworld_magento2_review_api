<?php

namespace Tweave\ReviewApi\Helper;

use Magento\Framework\App\ResourceConnection;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Reports\Model\ResourceModel\Review\CollectionFactory;
use Magento\Review\Model\ReviewFactory;

class ReviewHelper
{
    /**
     * @var \Magento\Review\Model\ResourceModel\Review\CollectionFactory
     */
    protected $reviewCollectionFactory;

    /**
     * @var ReviewFactory
     */
    protected $reviewFactory;

    /**
     * @var ResourceConnection
     */
    protected $resourceConnection;

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
    public function getReviewsByProductId($productId)
    {
        /** @var \Magento\Review\Model\ResourceModel\Review\Collection $reviewCollection */
        $reviewCollection = $this->reviewCollectionFactory->create();
        $reviewCollection
            ->addEntityFilter('product', $productId)
            ->setDateOrder();

        // You can apply additional filters or sorting as needed

        return $reviewCollection->getItems();
    }

    public function getReview($id)
    {

        $review = $this->reviewFactory->create()->load($id);
        if ( ! $review->getId()) {
            throw new NoSuchEntityException(__('No such entity with id %1', $id));
        }

        return $review;
    }

    public function initializeReview()
    {

        return $this->reviewFactory->create();
    }

    public function updateCustomerId($reviewId, $newCustomerId)
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
