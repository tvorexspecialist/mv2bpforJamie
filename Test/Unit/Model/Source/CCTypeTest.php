<?php

/**
 *
 * Billet Types Test.php
 *
 * @author      Webjump Core Team <dev@webjump.com.br>
 * @copyright   2017 Webjump (http://www.webjump.com.br)
 * @license     http://www.webjump.com.br  Copyright
 *
 * @link        http://www.webjump.com.br
 */

namespace Webjump\BraspagPagador\Test\Unit\Model\Source;

use Webjump\BraspagPagador\Model\Source\CCType;

class CCTypeTest extends \PHPUnit\Framework\TestCase
{
    private $model;

    protected function setUp()
    {
        $objectManager = new \Magento\Framework\TestFramework\Unit\Helper\ObjectManager($this);

        // mocks

        $this->model = $objectManager->getObject(
            CCType::class,
            []
        );
    }

    /** @test */
    public function test()
    {
        // prepare the test

        $expected = [
            'Simulado',
            'Cielo-Visa',
            'Cielo-Master',
            'Cielo-Amex',
            'Cielo-Elo',
            'Cielo-Aura',
            'Cielo-Jcb',
            'Cielo-Diners',
            'Cielo-Discover',
            'Rede-Visa',
            'Rede-Master',
            'Rede-Hipercard',
            'Rede-Hiper',
            'Rede-Elo',
            'Rede-Diners',
            'RedeSitef-Visa',
            'RedeSitef-Master',
            'RedeSitef-Hipercard',
            'RedeSitef-Diners',
            'CieloSitef-Visa',
            'CieloSitef-Master',
            'CieloSitef-Amex',
            'CieloSitef-Elo',
            'CieloSitef-Aura',
            'CieloSitef-Jcb',
            'CieloSitef-Diners',
            'CieloSitef-Discover',
            'SantanderSitef-Visa',
            'SantanderSitef-Master',
        ];

        // perform the changes

        $result = $this->model->getAllowedTypes();

        // test the results

        static::assertEquals($expected, $result);
    }
}
