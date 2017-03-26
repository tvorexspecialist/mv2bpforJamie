<?php

namespace Webjump\BraspagPagador\Gateway\Transaction\CreditCard\Resource\AntiFraud\MDD;


class GeneralRequest extends AbstractMDD implements AdapterGeneralInterface
{
    public function getCustomerName()
    {
        return trim(
            $this->getConfig()->getCustomer()->getFirstname() .
            ' ' .
            $this->getConfig()->getCustomer()->getLastname()
        );
    }

    public function getCustomerIsLogged()
    {
        $quote = $this->getConfig()->getQuote();
        $result = (bool) $quote->getCustomerIsGuest();

        return ($result) ? 'Sim' : 'Não';
    }

    public function getPurchaseByThird()
    {
        $billing = $this->getConfig()->getQuote()->getBillingAddress();
        $shipping = $this->getConfig()->getQuote()->getShippingAddress();

        $result = false;
        if ($billing->getPostcode() !== $shipping->getPostcode()) {
            $result = true;
        }

        return ($result) ? 'Sim' : 'Não';
    }

    public function getSalesOrderChannel()
    {
        if ($this->getMobileDetect()->isMobile() || $this->getMobileDetect()->isTablet()) {
            return 'Movel';
        }

        return 'Web';
    }

    public function getProductCategory()
    {
        return null;
    }

    public function getShippingMethod()
    {
        $quote = $this->getConfig()->getQuote();
        return $quote->getShippingAddress()->getShippingMethod();
    }

    public function getCouponCode()
    {
        return $this->getConfig()->getQuote()->getCouponCode();
    }

    public function getCustomerFetchSelf()
    {
        $result = false;

        if ($this->getConfig()->getQuote()->getShippingMethod() === $this->getConfig()->getFetchSelfShippingMethod()) {
            $result = true;
        }

        return ($result) ? 'Sim' : 'Não';

    }

    public function getStoreCode()
    {
        return $this->getConfig()->getStoreCode();
    }

    public function getHasGiftCard()
    {
        $quote = $this->getConfig()->getQuote();

        $result = false;
        if ((bool) $quote->getGiftMessageId()){
            $result = true;
        }

        return ($result) ? 'Sim' : 'Não';
    }

    public function getSecondPaymentMethod()
    {
        return null;
    }

    public function getPaymentMethodQTY()
    {
        return 1;
    }

    public function getShippingMethodAmount()
    {
        $quote = $this->getConfig()->getQuote();
        return number_format($quote->getShippingAddress()->getShippingAmount(), 2, '.', '');
    }

    public function getSecondPaymentMethodAmount()
    {
        return null;
    }

    public function getSalesOrderAmount()
    {
        $grandTotal = $this->getConfig()->getQuote()->getGrandTotal();
        return number_format($grandTotal, 2, '.', '');
    }

    public function getQtyInstallmentsOrder()
    {
        return (int) $this->getPaymentData()->getAdditionalInformation('cc_installments');
    }

    public function getCreditCardIsPrivateLabel()
    {
        return 'Não';
    }

    public function getCustomerIdentity()
    {
        return $this->getConfig()->getCustomer()->getTaxvat();
    }

    public function getCustomerTelephone()
    {
        $quote = $this->getConfig()->getQuote();
        $result = $quote->getBillingAddress()->getTelephone();

        return (int) preg_replace('/[^0-9]/','', $result);
    }

    public function getStoreIdentity()
    {
        return $this->getConfig()->getStoreIdentity();
    }

    public function getProvider()
    {
        return null;
    }

    public function getCustomerIsRisk()
    {
        return null;
    }

    public function getCustomerIsVIP()
    {
        return null;
    }

}
