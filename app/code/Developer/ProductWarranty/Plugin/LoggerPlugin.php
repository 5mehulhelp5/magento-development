<?php

namespace Developer\ProductWarranty\Plugin;

use Developer\ProductWarranty\Api\Warranty\WarrantyInterface;
use Developer\ProductWarranty\Model\WarrantyRepository;
use Magento\Framework\Event\ManagerInterface as EventManager;
use Magento\Framework\Exception\LocalizedException;

class LoggerPlugin
{
    private EventManager $eventManager;

    public function __construct(EventManager $eventManager)
    {
        $this->eventManager = $eventManager;
    }

    public function aroundSave(WarrantyRepository $subject, callable $proceed, $warranty)
    {
        $oldData = $this->getOldWarranty($subject, $warranty);

        $dateTime = date('Y-m-d H:i:s');
        $returnValue = $proceed($warranty);

        $this->dispatchEvent($oldData, $returnValue, $dateTime);

        return $returnValue;
    }

    public function dispatchEvent($old, $new, $dateTime): void
    {
        $this->eventManager->dispatch('my_event', ['old' => $old, 'new' => $new, 'dateTime' => $dateTime]);
    }

    public function getOldWarranty(WarrantyRepository $subject, $warranty): ?WarrantyInterface
    {
        $oldData = null;

        try {
            $oldData = $subject->getByProductId($warranty->getProductId());
        } catch (\Magento\Framework\Exception\NoSuchEntityException|LocalizedException $e) {

        }
        return $oldData;
    }
}
