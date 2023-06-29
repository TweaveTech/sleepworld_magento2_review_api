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
    public function create(ReviewDataInterface $reviewData);

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
    public function get($id);

    /**
     * @api
     * @param int $id
     * @return array
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\CouldNotDeleteException
     */
    public function delete($id);

    /**
     * @api
     * @param string $productSku
     * @return \Tweave\ReviewApi\Api\Data\ReviewDataInterface[]
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function listByProductSku($productSku);
}
