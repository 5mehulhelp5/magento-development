<?php
namespace Developer\Promotion\Block\Widget;

use Magento\Framework\View\Element\Template;
use Magento\Widget\Block\BlockInterface;

class Promotion extends Template implements BlockInterface
{
    protected $_template = 'widget/promotion.phtml';

    /**
     * Helper getter: returns widget param or default
     */
    public function getTitle(): ?string
    {
        return $this->getData('title') ?: null;
    }

    public function isBadgeVisible(): bool
    {
        // widget select returns '1'/'0' or similar
        return (bool) $this->getData('show_badge');
    }

    public function getMessage(): ?string
    {
        return $this->getData('message') ?: null;
    }
}
