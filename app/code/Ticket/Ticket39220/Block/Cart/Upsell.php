<?php

namespace Ticket\Ticket39220\Block\Cart;

class Upsell extends \Magento\Framework\View\Element\Template
{
    protected $_cartHelper;
    protected $_cart;
    protected $_formKey;

    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Catalog\Block\Product\Context           $productcontext,
        \Magento\Framework\Data\Form\FormKey             $formKey,
        \Magento\Checkout\Model\Cart                     $cart,
        \Magento\Catalog\Model\ProductFactory            $product
    )
    {
        $this->_cartHelper = $productcontext->getCartHelper();
        $this->_formKey = $formKey;
        $this->_cart = $cart;
        $this->_product = $product;
        parent::__construct($context);
    }

    public function getAddToCartUrl($product, $additional = [])
    {
        if (!$product->getTypeInstance()->isPossibleBuyFromList($product)) {
            if (!isset($additional['_escape'])) {
                $additional['_escape'] = true;
            }
            if (!isset($additional['_query'])) {
                $additional['_query'] = [];
            }
            $additional['_query']['options'] = 'cart';

            return $this->getProductUrl($product, $additional);
        }
        return $this->_cartHelper->getAddUrl($product, $additional);
    }

    public function getFormKey()
    {
        return $this->_formKey->getFormKey();
    }

    public function getQuoteItem()
    {
        return $this->_cart->getQuote()->getAllItems();
    }

    public function getLoadProduct($id)
    {
        return $this->_product->create()->load($id);
    }

    public function getProductId()
    {
        $itemsCollection = $this->_cart->getQuote()->getItemsCollection();
        $itemsCollection->getSelect()->order('updated_at');
        $latestItem = $itemsCollection->getLastItem();
        $lastestProductID = $latestItem->getProductId();
        return $lastestProductID;
    }
}
