<?php
namespace WindAndeddu\GoogleFormPage\Model\Config\Backend;

/**
 * Class Serialized
 *
 * @package WindAndeddu\GoogleFormPage\Model\Config\Backend
 */
class Serialized extends \Magento\Config\Model\Config\Backend\Serialized\ArraySerialized
{
    /**
     * @var \Magento\PageCache\Model\Config
     */
    protected $_pageCacheConfig;

    /**
     * @var \Magento\CacheInvalidate\Model\PurgeCache
     */
    protected $_pageCacheCleaner;

    public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\App\Config\ScopeConfigInterface $config,
        \Magento\PageCache\Model\Config $pageCacheConfig,
        \Magento\CacheInvalidate\Model\PurgeCache $pageCacheCleaner,
        \Magento\Framework\App\Cache\TypeListInterface $cacheTypeList,
        \Magento\Framework\Model\ResourceModel\AbstractResource $resource = null,
        \Magento\Framework\Data\Collection\AbstractDb $resourceCollection = null,
        array $data = [],
        \Magento\Framework\Serialize\Serializer\Json $serializer = null
    )
    {
        $this->_pageCacheConfig = $pageCacheConfig;
        $this->_pageCacheCleaner = $pageCacheCleaner;

        parent::__construct($context, $registry, $config, $cacheTypeList, $resource, $resourceCollection, $data, $serializer);
    }

    /**
     * Processing object before save data
     *
     * @return $this
     */
    public function beforeSave()
    {
        if ($this->_pageCacheConfig->isEnabled() && $this->_pageCacheConfig->getType() == \Magento\PageCache\Model\Config::VARNISH) {
            $this->_pageCacheCleaner->sendPurgeRequest(\WindAndeddu\GoogleFormPage\Model\Configuration::CACHE_TAG);
        }

        parent::beforeSave();
        return $this;
    }


    public function validateBeforeSave()
    {
        /* @var $formPages array */
        $formPages = $this->getValue();

        $urlKeys = [];
        foreach ($formPages as $formPage) {
            if ($formPage) {
                $urlKeys[] = $formPage['page_url_key'];
            }
        }

        $uniqueUrlKeys = array_unique($urlKeys);
        if ($duplicates = array_diff_assoc($urlKeys, $uniqueUrlKeys)) {
            throw new \InvalidArgumentException(__("'Url Key' must contain only unique values. Duplicate: '%1'", implode(', ',$duplicates)));
        }

        return parent::validateBeforeSave();
    }
}
