<?php

namespace Tweave\ReviewApi\Model;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\Config\ValueInterface;

class Config implements ValueInterface
{
    const XML_PATH_RATING_ID = 'tweave_reviewapi/general/rating_id';

    protected $configValue;
    protected $fieldsetDataValue;
    protected $oldValue;
    protected $isValueChanged;

    public function __construct(
        ScopeConfigInterface $configValue
    ) {
        $this->configValue = $configValue;
    }

    /**
     * Get the configured rating ID.
     *
     * @return int|null
     */
    public function getRatingId(): ?int
    {
        return (int) $this->configValue->getValue(self::XML_PATH_RATING_ID);
    }

    /**
     * @inheritdoc
     */
    public function getFieldsetDataValue($key)
    { }

    /**
     * @inheritdoc
     */
    public function getOldValue()
    {
        return $this->oldValue;
    }

    /**
     * @inheritdoc
     */
    public function isValueChanged()
    {
        return $this->isValueChanged;
    }

    /**
     * @inheritdoc
     */
    public function afterSave()
    {
        // Additional logic after the configuration is saved, if needed.
    }
}
