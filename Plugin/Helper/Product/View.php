<?php

declare(strict_types=1);

namespace Marissen\LongMetaDescription\Plugin\Helper\Product;

use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Catalog\Helper\Product\View as Subject;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\View\Result\Page as ResultPage;
use Magento\Catalog\Api\ProductRepositoryInterface;

class View
{
    /**
     * @var ProductRepositoryInterface
     */
    private $productRepository;

    /**
     * View constructor.
     * @param ProductRepositoryInterface $productRepository
     */
    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    /**
     * @param Subject $subject
     * @param $result
     * @param ResultPage $resultPage
     * @param $productId
     * @param $controller
     * @param null $params
     * @return mixed
     */
    public function afterPrepareAndRender(
        Subject $subject,
        $result,
        ResultPage $resultPage,
        $productId,
        $controller,
        $params = null
    ) {
        /** @var \Magento\Catalog\Model\Product $product */
        $product = $this->getProductById($productId);

        if (!$product) {
            return $result;
        }

        $longMetaDescription = $product->getData('long_meta_description');

        if (empty($longMetaDescription)) {
            return $result;
        }

        $pageConfig = $resultPage->getConfig();
        $pageConfig->setDescription($longMetaDescription);

        return $result;
    }

    /**
     * @param $productId
     * @return ProductInterface|null
     */
    private function getProductById($productId): ?ProductInterface
    {
        try {
            return $this->productRepository->getById($productId);
        } catch (NoSuchEntityException $e) {
            return null;
        }
    }
}
