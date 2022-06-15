<?php
declare(strict_types=1);

namespace WindAndeddu\GoogleFormPageGraphQl\Model\Resolver;

/**
 * Class GoogleFormPage
 *
 * @package WindAndeddu\GoogleFormPageGraphQl\Model\Resolver
 */
class GoogleFormPage implements \Magento\Framework\GraphQl\Query\ResolverInterface
{
    /**
     * @var \WindAndeddu\GoogleFormPage\Model\Configuration
     */
    protected $_configuration;

    /**
     * @param \WindAndeddu\GoogleFormPage\Model\Configuration $configuration
     */
    public function __construct(
        \WindAndeddu\GoogleFormPage\Model\Configuration $configuration
    ) {
        $this->_configuration = $configuration;
    }

    /**
     * @param \Magento\Framework\GraphQl\Config\Element\Field $field
     * @param $context
     * @param \Magento\Framework\GraphQl\Schema\Type\ResolveInfo $info
     * @param array|null $value
     * @param array|null $args
     * @return array
     * @throws \Magento\Framework\GraphQl\Exception\GraphQlNoSuchEntityException
     * @throws \Magento\Framework\GraphQl\Exception\GraphQlInputException
     */
    public function resolve(
        \Magento\Framework\GraphQl\Config\Element\Field $field,
        $context,
        \Magento\Framework\GraphQl\Schema\Type\ResolveInfo $info,
        array $value = null,
        array $args = null
    ): array {
        if (empty($args['page_url_key'])) {
            throw new \Magento\Framework\GraphQl\Exception\GraphQlInputException(__("'page_url_key' input argument is required."));
        }
        $data = [];

        $formPages = $this->_configuration->getGoogleFormPageConfiguration();

        foreach ($formPages as $formPage) {
            if ($formPage['page_url_key'] == $args['page_url_key']) {
                $data = $formPage;
                break;
            }
        }

        if (!$data) {
            throw new \Magento\Framework\GraphQl\Exception\GraphQlNoSuchEntityException(
                __("Form Page with url_key '%1' does not exist", $args['page_url_key'])
            );
        }

        return $data;
    }
}
