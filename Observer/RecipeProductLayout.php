<?php

namespace Magento360\Recipe\Observer;

use Magento\Framework\Registry;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Event\Observer;

class RecipeProductLayout implements ObserverInterface
{
    const ACTION_NAME = 'catalog_product_view';

    /** @var Registry */
    private $registry;
    protected $attributeSet;

    public function __construct(
        Registry $registry,
        \Magento\Eav\Api\AttributeSetRepositoryInterface $attributeSet
    ) {
        $this->registry = $registry;
        $this->attributeSet = $attributeSet;
    }

    public function execute(Observer $observer)
    {
        if ($observer->getFullActionName() !== self::ACTION_NAME) {
            return;
        }

        $product = $this->registry->registry('current_product');

        $attributeSetRepository = $this->attributeSet->get($product->getAttributeSetId());
        $attributeSetName = $attributeSetRepository->getAttributeSetName();

        if ($attributeSetName == "Recipe"){
            /** @var \Magento\Framework\View\Layout $layout */
            $layout = $observer->getLayout();
            $layout->getUpdate()->addHandle(self::ACTION_NAME . '_recipe');
        }


    }
}
