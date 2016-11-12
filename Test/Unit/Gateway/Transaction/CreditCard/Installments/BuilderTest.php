<?php

namespace Webjump\BraspagPagador\Test\Unit\Gateway\Transaction\CreditCard\Installments;

use Webjump\BraspagPagador\Gateway\Transaction\CreditCard\Resource\Installments\Builder;

class BuilderTest extends \PHPUnit_Framework_TestCase
{
    private $builder;

    private $installmentFactoryMock;

    private $installmentsConfigMock;

    private $cartMock;

    public function setUp()
    {
        $this->installmentFactoryMock = $this->getMock('Webjump\BraspagPagador\Gateway\Transaction\CreditCard\Resource\Installments\InstallmentFactoryInterface');

        $this->installmentsConfigMock = $this->getMock('Webjump\BraspagPagador\Gateway\Transaction\CreditCard\Config\InstallmentsConfigInterface');

        $this->cartMock = $this->getMock('Magento\Checkout\Model\Cart\CartInterface');

        $this->builder = new Builder(
            $this->installmentFactoryMock,
            $this->installmentsConfigMock,
            $this->cartMock
        );        
    }

    public function testBuild()
    {
        $this->installmentsConfigMock->expects($this->once())
            ->method('getInstallmentsNumber')
            ->will($this->returnValue(3));

        $quoteMock = $this->getMockBuilder('Magento\Quote\Model\Quote')
            ->setMethods(['getGrandTotal'])
            ->disableOriginalConstructor()
            ->getMock();

        $quoteMock->expects($this->once())
            ->method('getGrandTotal')
            ->will($this->returnValue('100.00'));

        $this->cartMock->expects($this->once())
            ->method('getQuote')
            ->will($this->returnValue($quoteMock));

        $installments1 = $this->getMock('Webjump\BraspagPagador\Gateway\Transaction\CreditCard\Resource\Installments\InstallmentInterface');
        $installments2 = $this->getMock('Webjump\BraspagPagador\Gateway\Transaction\CreditCard\Resource\Installments\InstallmentInterface');
        $installments3 = $this->getMock('Webjump\BraspagPagador\Gateway\Transaction\CreditCard\Resource\Installments\InstallmentInterface');

        $this->installmentFactoryMock->expects($this->at(0))
            ->method('create')
            ->with(1, 100.00, $this->installmentsConfigMock)
            ->will($this->returnValue($installments1));

        $this->installmentFactoryMock->expects($this->at(1))
            ->method('create')
            ->with(2, 100.00, $this->installmentsConfigMock)
            ->will($this->returnValue($installments2));

        $this->installmentFactoryMock->expects($this->at(2))
            ->method('create')
            ->with(3, 100.00, $this->installmentsConfigMock)
            ->will($this->returnValue($installments3));

        $expected = [
            $installments1,
            $installments2,
            $installments3,
        ];

        $result = $this->builder->build();

        static::assertEquals($expected, $result);
    }

    public function testBuildWithInstallMinAmount()
    {
        $this->installmentsConfigMock->expects($this->once())
            ->method('getInstallmentsNumber')
            ->will($this->returnValue(3));

        $this->installmentsConfigMock->expects($this->exactly(1))
            ->method('getInstallmentMinAmount')
            ->will($this->returnValue(3));

        $quoteMock = $this->getMockBuilder('Magento\Quote\Model\Quote')
            ->setMethods(['getGrandTotal'])
            ->disableOriginalConstructor()
            ->getMock();

        $quoteMock->expects($this->once())
            ->method('getGrandTotal')
            ->will($this->returnValue('5.00'));

        $this->cartMock->expects($this->once())
            ->method('getQuote')
            ->will($this->returnValue($quoteMock));

        $installments1 = $this->getMock('Webjump\BraspagPagador\Gateway\Transaction\CreditCard\Resource\Installments\InstallmentInterface');

        $this->installmentFactoryMock->expects($this->at(0))
            ->method('create')
            ->with(1, 5.00, $this->installmentsConfigMock)
            ->will($this->returnValue($installments1));

        $expected = [
            $installments1,
        ];

        $result = $this->builder->build();

        static::assertEquals($expected, $result);
    }
}