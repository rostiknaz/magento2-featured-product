<?php
declare(strict_types=1);

namespace Rnazy\FeaturedProduct\Model\Config\Backend;

use Magento\Catalog\Api\Data\ProductInterfaceFactory;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Catalog\Model\Product;
use Magento\Framework\App\Cache\TypeListInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\Config\Value;
use Magento\Framework\Data\Collection\AbstractDb;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Model\Context;
use Magento\Framework\Model\ResourceModel\AbstractResource;
use Magento\Framework\Registry;

/**
 * Validate real sku
 */
class ProductSku extends Value
{
    private ProductRepositoryInterface $productRepository;

    public function __construct(
        Context $context,
        Registry $registry,
        ScopeConfigInterface $config,
        TypeListInterface $cacheTypeList,
        ProductRepositoryInterface $productRepository,
        AbstractResource $resource = null,
        AbstractDb $resourceCollection = null,
        array $data = []
    ) {
        parent::__construct($context, $registry, $config, $cacheTypeList, $resource, $resourceCollection, $data);
        $this->productRepository = $productRepository;
    }

    /**
     * @inheritDoc
     * @throws LocalizedException
     */
    public function beforeSave()
    {
        $this->validateSku();

        return parent::beforeSave();
    }

    /**
     * Validates config value
     *
     * @throws LocalizedException
     */
    public function validateSku(): void
    {
        if ($this->isValueChanged()) {
            // throws an exception if product sku does not exist
            /** @var Product $product */
            $product = $this->productRepository->get($this->getValue());

            if (!$product->isSaleable()) {
                throw new LocalizedException(
                    __('Product "%1" is not saleable. Verify the product and try again.', $this->getValue())
                );
            }
        }
    }
}
