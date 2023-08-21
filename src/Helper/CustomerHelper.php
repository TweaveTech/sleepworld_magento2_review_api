<?php

namespace Tweave\ReviewApi\Helper;

use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Customer\Api\Data\CustomerInterface;
use Magento\Customer\Model\CustomerRegistry;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Reports\Model\ResourceModel\Review\CollectionFactory;
use Magento\Store\Api\StoreRepositoryInterface;

class CustomerHelper
{
    /**
     * @var CustomerRepositoryInterface
     */
    protected $customerRepository;
    /**
     * @var CustomerRegistry
     */
    protected $customerRegistry;
    /**
     * @var StoreRepositoryInterface
     */
    protected $storeRepository;

    /**
     * @param  CustomerRepositoryInterface  $customerRepository
     * @param  CustomerRegistry  $customerRegistry
     * @param  StoreRepositoryInterface  $storeRepository
     */
    public function __construct(
        CustomerRepositoryInterface $customerRepository,
        CustomerRegistry $customerRegistry,
        StoreRepositoryInterface $storeRepository,
    ) {
        $this->customerRepository = $customerRepository;
        $this->customerRegistry = $customerRegistry;
        $this->storeRepository = $storeRepository;
    }

    /**
     * @param  string  $customerEmail
     * @param $storeId
     *
     * @return CustomerInterface|null
     * @throws NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getCustomerByEmail(?string $customerEmail, ?string $storeId = null): ?CustomerInterface
    {
        if ($customerEmail == null) {
            return null;
        }

        $websiteId = null;

        if (!empty($storeId)) {
            $store = $this->storeRepository->getById($storeId);
            $websiteId = $store->getWebsiteId();
        }

        $this->customerRegistry->removeByEmail($customerEmail, $websiteId);

        try {
            $this->customerRegistry->removeByEmail($customerEmail, $websiteId);
            return $this->customerRepository->get($customerEmail, $websiteId);
        } catch (\Magento\Framework\Exception\NoSuchEntityException $e) {
            return null;
        }
    }

    public function getCustomerId(?CustomerInterface $customer): ?int
    {
        return $customer ? (int) $customer->getId() : null;
    }

    public function getReviewNickname(?CustomerInterface $customer,string $customerName): string
    {
        return $customer ? trim(implode(' ', array_filter([$customer->getFirstName(), $customer->getMiddleName(), $customer->getLastName()]))) : $customerName;
    }

}
