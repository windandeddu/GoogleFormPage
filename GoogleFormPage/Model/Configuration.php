<?php
namespace WindAndeddu\GoogleFormPage\Model;

/**
 * Class Configuration
 *
 * @package WindAndeddu\GoogleFormPage\Model\Configuration
 */
class Configuration
{
    const XML_PATH_GOOGLE_FORM_PAGE_CONFIGURATION = 'google_form_page/google_form_page_config/dynamic_google_form';

    const CACHE_TAG = 'google_form_page';

    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $_scopeConfig;

    /**
     * @var \Magento\Framework\Serialize\Serializer\Json
     */
    protected $_jsonSerializer;

    /**
     * Countries constructor.
     *
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     * @param \Magento\Framework\Serialize\Serializer\Json $jsonSerializer
     */
    public function __construct(
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Framework\Serialize\Serializer\Json $jsonSerializer
    ) {
        $this->_scopeConfig = $scopeConfig;
        $this->_jsonSerializer = $jsonSerializer;
    }

    public function getGoogleFormPageConfiguration()
    {
        if ($serializedData = $this->_scopeConfig->getValue(
            self::XML_PATH_GOOGLE_FORM_PAGE_CONFIGURATION,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        )) {

            return $this->_jsonSerializer->unserialize($serializedData);
        }

        throw new \Symfony\Component\OptionsResolver\Exception\NoConfigurationException(__("Form configuration was not set."));
    }


}
