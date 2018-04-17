<?php

declare(strict_types=1);

namespace Marissen\LongMetaDescription\Plugin\Block\Product;

use Magento\Catalog\Block\Product\View as Subject;
use Magento\Framework\View\Page\Config;

class View
{
    /**
     * @var Config
     */
    private $pageConfig;

    /**
     * View constructor.
     * @param Config $pageConfig
     */
    public function __construct(Config $pageConfig)
    {
        $this->pageConfig = $pageConfig;
    }

    /**
     * @param Subject $subject
     * @param $result
     * @return mixed
     */
    public function afterSetLayout(Subject $subject, $result)
    {
        $product = $subject->getProduct();

        $longMetaDescription = $product->getData('long_meta_description');
        if (empty($longMetaDescription)) {
            return $result;
        }

        $this->pageConfig->setDescription($longMetaDescription);

        return $result;
    }
}
