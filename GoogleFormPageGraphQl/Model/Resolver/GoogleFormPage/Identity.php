<?php
declare(strict_types=1);

namespace WindAndeddu\GoogleFormPageGraphQl\Model\Resolver\GoogleFormPage;

/**
 * Class Identity
 *
 * @package WindAndeddu\GoogleFormPageGraphQl\Model\Resolver\GoogleFormPage
 */
class Identity implements \Magento\Framework\GraphQl\Query\Resolver\IdentityInterface
{
    /**
     * @param array $resolvedData
     * @return array
     */
    public function getIdentities(array $resolvedData): array
    {
        return [\WindAndeddu\GoogleFormPAge\Model\Configuration::CACHE_TAG];
    }
}
