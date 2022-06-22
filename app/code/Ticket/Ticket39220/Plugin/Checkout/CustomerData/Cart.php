<?php

namespace Ticket\Ticket39220\Plugin\Checkout\CustomerData;

use Magento\Checkout\Model\Session as CheckoutSession;
use Magento\Checkout\Helper\Data as CheckoutHelper;
use Magento\Quote\Model\Quote;
use Magento\Catalog\Api\ProductRepositoryInterface;

class Cart
{
    /**
     * @var CheckoutSession
     */
    protected $checkoutSession;

    /**
     * @var CheckoutHelper
     */
    protected $checkoutHelper;

    /**
     * @var Quote|null
     */
    protected $quote = null;

    /**
     * @param CheckoutSession $checkoutSession
     * @param CheckoutHelper $checkoutHelper
     */
    public function __construct(
        CheckoutSession                       $checkoutSession,
        CheckoutHelper                        $checkoutHelper,
        ProductRepositoryInterface            $productRepository,
        \Magento\Framework\View\LayoutFactory $layoutFactory
    )
    {
        $this->checkoutSession = $checkoutSession;
        $this->checkoutHelper = $checkoutHelper;
        $this->productRepository = $productRepository;
        $this->layoutFactory = $layoutFactory;
    }

    /**
     * Add grand total to result
     *
     * @param \Magento\Checkout\CustomerData\Cart $subject
     * @param array $result
     * @return array
     */
    public function afterGetSectionData(
        \Magento\Checkout\CustomerData\Cart $subject,
                                            $result
    )
    {
        $upselldata = $this->layoutFactory->create()
            ->createBlock(\Ticket\Ticket39220\Block\Cart\Upsell::class)
            ->setTemplate('Ticket_Ticket39220::minicart/upsell.phtml')
            ->toHtml();
        $result['advancecart']['upsell_data'] = $upselldata;

        return $result;
    }
}
