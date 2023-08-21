<?php
namespace Tweave\ReviewApi\Api;

use Tweave\ReviewApi\Api\Data\ReviewDataInterface;

interface ReviewRepositoryInterface
{
    /**
     * @param ReviewDataInterface $reviewData
     * @return array
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function create(ReviewDataInterface $reviewData): array;

    /**
     * @api
     * @param int $id
     * @return array
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function update(int $id, ReviewDataInterface $reviewData);

    /**
     * @api
     * @param int $id
     * @return array
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function get(int $id): array;

    /**
     * @api
     * @param int $id
     * @return array
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\CouldNotDeleteException
     */
    public function delete(int $id): array;

    /**
     * @api
     * @param string $productSku
     * @return array
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function listByProductSku(string $productSku): array;
}
