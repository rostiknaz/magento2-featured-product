<?php
declare(strict_types=1);

namespace Rnazy\FeaturedProduct\Model;

use Magento\Framework\App\Config\ScopeConfigInterface;

class ConfigProvider
{
    public const IS_ENABLED_CONFIG_PATH = 'rnazy_featured_product/general/enabled';

    public const PRODUCT_SKU_CONFIG_PATH = 'rnazy_featured_product/general/product_sku';

    private ScopeConfigInterface $config;

    /**
     * @param ScopeConfigInterface $config
     */
    public function __construct(ScopeConfigInterface $config)
    {
        $this->config = $config;
    }

    /**
     * Flag to show Feature Product banner on homepage.
     *
     * @return bool
     */
    public function isEnabled(): bool
    {
        return $this->config->isSetFlag(self::IS_ENABLED_CONFIG_PATH);
    }

    /**
     * Get SKU of product to be shown on a homepage Feature Product banner.
     *
     * @return string
     */
    public function getProductSku(): string
    {
        return (string) $this->config->getValue(self::PRODUCT_SKU_CONFIG_PATH);
    }
}
