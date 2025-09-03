<?php
namespace Developer\ProductWarranty\Plugin;

use Developer\ProductWarranty\Api\WarrantyRepositoryInterface;
use Magento\Catalog\Api\ProductRepositoryInterface;

class WarrantyPlugin
{
    protected WarrantyRepositoryInterface $warrantyRepository;

    public function __construct(WarrantyRepositoryInterface $warrantyRepository)
    {
        $this->warrantyRepository = $warrantyRepository;
    }

    public function afterGet(ProductRepositoryInterface $subject, $product)
    {
        $warranty = $this->warrantyRepository->getByProductId($product->getId());
        $extension = $product->getExtensionAttributes();
        if (!$extension) {
            $extension = $product->getExtensionAttributesFactory()->create(get_class($product));
        }
        $extension->setWarranty($warranty?->getWarranty());
        $product->setExtensionAttributes($extension);
        return $product;
    }

    public function afterGetList(ProductRepositoryInterface $subject, $searchResults)
    {
        foreach ($searchResults->getItems() as $product) {
            $this->afterGet($subject, $product);
        }
        return $searchResults;
    }
}
