<?php
declare(strict_types=1);

namespace Rnazy\FeaturedProduct\Block;

use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Catalog\Block\Product\Image;
use Magento\Catalog\Block\Product\ImageFactory as ProductImageFactory;
use Magento\Catalog\Model\Product;
use Magento\Catalog\Model\ProductFactory;
use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\View\Element\Template;
use Rnazy\FeaturedProduct\Model\ConfigProvider;

class FeaturedProduct extends Template implements IdentityInterface
{
    private ConfigProvider $config;

    protected ProductImageFactory $productImageFactory;

    protected ProductRepositoryInterface $productRepository;

    protected ProductFactory $productFactory;

    private ?ProductInterface $product = null;

    public function __construct(
        ConfigProvider $configProvider,
        ProductImageFactory $productImageFactory,
        ProductRepositoryInterface $productRepository,
        ProductFactory $productFactory,
        Template\Context $context,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->productImageFactory = $productImageFactory;
        $this->productRepository = $productRepository;
        $this->productFactory = $productFactory;
        $this->config = $configProvider;
    }

    /**
     * @return Product
     */
    public function getProduct(): ProductInterface
    {
        if (!$this->product || !$this->product->getId()) {
            $sku = $this->config->getProductSku();

            try {
                if (empty($sku)) {
                    throw new LocalizedException(__('Product sku is required.'));
                }

                $this->product = $this->productRepository->get($sku);
            } catch (LocalizedException) {
                $this->product = $this->productFactory->create();
            }
        }

        return $this->product;
    }

    /**
     * Get product base image block.
     *
     * @param Product $product
     * @return Image
     */
    public function getBaseImageBlock(Product $product): Image
    {
        return $this->productImageFactory->create($product, 'product_base_image');
    }

    /**
     * Return identifiers for produced content (to refresh block cache if product data has changed)
     *
     * @return array
     */

    public function getIdentities(): array
    {
        return $this->getProduct()->getIdentities();
    }

    /**
     * @return string
     */
    protected function _toHtml(): string
    {
        if (!$this->config->isEnabled()) {
            return '';
        }

        $product = $this->getProduct();

        if (!$product->getId() || !$product->isSalable()) {
            return '';
        }

        return parent::_toHtml();
    }
}
