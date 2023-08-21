<?php

namespace Tweave\ReviewApi\Model;

use Magento\Framework\Exception\NoSuchEntityException;
use Tweave\ReviewApi\Api\ReviewRepositoryInterface;
use Tweave\ReviewApi\Api\Data\ReviewDataInterface;
use Tweave\ReviewApi\Handler\ReviewCreateHandler;
use Tweave\ReviewApi\Handler\ReviewDeleteHandler;
use Tweave\ReviewApi\Handler\ReviewGetHandler;
use Tweave\ReviewApi\Handler\ReviewListHandler;
use Tweave\ReviewApi\Handler\ReviewUpdateHandler;
use Tweave\ReviewApi\Helper\CustomerHelper;
use Tweave\ReviewApi\Helper\ProductHelper;
use Tweave\ReviewApi\Helper\RatingHelper;
use Tweave\ReviewApi\Helper\ReviewHelper;

class ReviewRepository implements ReviewRepositoryInterface
{

    protected CustomerHelper $customerHelper;
    protected ProductHelper $productHelper;
    protected RatingHelper $ratingHelper;
    protected ReviewHelper $reviewHelper;

    public function __construct(
        CustomerHelper $customerHelper,
        ProductHelper $productHelper,
        RatingHelper $ratingHelper,
        ReviewHelper $reviewHelper,
    ) {
        $this->customerHelper = $customerHelper;
        $this->productHelper = $productHelper;
        $this->ratingHelper = $ratingHelper;
        $this->reviewHelper = $reviewHelper;
    }

    /**
     * @param  ReviewDataInterface  $reviewData
     *
     * @return array
     * @throws \Magento\Framework\Exception\LocalizedException
     * @api
     */
    public function create(ReviewDataInterface $reviewData): array
    {
        try {
            $handler = new ReviewCreateHandler(
                $this->customerHelper,
                $this->productHelper,
                $this->ratingHelper,
                $this->reviewHelper
            );

            $review = $handler($reviewData);
            $response = ['success' => true, 'review' => $review];

            return [
                'data' => $response
            ];

        } catch (\Exception $e) {
            throw new \Magento\Framework\Exception\LocalizedException(__('Error creating review: ' . $e->getMessage()));
        }
    }

    /**
     * @param  int  $id
     * @param  ReviewDataInterface  $reviewData
     *
     * @return array[]
     * @throws NoSuchEntityException
     * @api
     */
    public function update(int $id, ReviewDataInterface $reviewData): array
    {
        try {
            $handler = new ReviewUpdateHandler(
                $this->customerHelper,
                $this->ratingHelper,
                $this->reviewHelper
            );

            $updatedReview = $handler($id, $reviewData);
            $response = ['success' => true, 'review' => $updatedReview];

            return [
                'data' => $response
            ];

        } catch (\Exception $e) {
            throw new \Magento\Framework\Exception\NoSuchEntityException(__('Error updating review: ' . $e->getMessage()));
        }
    }

    /**
     * @param  int  $id
     *
     * @return array
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @api
     */
    public function get(int $id): array
    {
        try {
            $handler = new ReviewGetHandler(
                $this->ratingHelper,
                $this->reviewHelper
            );

            $review = $handler($id);
            $response = ['success' => true, 'review' => $review];

            return [
                'data' => $response
            ];

        } catch (\Exception $e) {
            throw new \Magento\Framework\Exception\NoSuchEntityException(__('Error fetching review: ' . $e->getMessage()));
        }
    }

    /**
     * @param  int  $id
     *
     * @return array
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\CouldNotDeleteException
     * @api
     */
    public function delete(int $id): array
    {
        try {
            $handler = new ReviewDeleteHandler($this->reviewHelper);

            if ($handler($id)) {
                return [
                    'data' => ['success' => true, 'message' => 'Review successfully deleted.']
                ];
            } else {
                throw new \Exception("Handler failed to delete the review");
            }

        } catch (\Exception $e) {
            return [
                'data' => ['success' => false, 'message' => 'Failed to delete review. Error: ' . $e->getMessage()]
            ];
        }
    }

    /**
     * @param  string  $productSku
     *
     * @return array
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @api
     */
    public function listByProductSku(string $productSku): array
    {
        try {
            $handler = new ReviewListHandler(
                $this->productHelper,
                $this->ratingHelper,
                $this->reviewHelper
            );

            $reviews = $handler($productSku);
            $response = ['success' => true, 'reviews' => $reviews];

            return [
                'data' => $response
            ];
        } catch (\Exception $e) {
            throw new \Magento\Framework\Exception\LocalizedException(__('Error fetching reviews: ' . $e->getMessage()));
        }
    }

}
