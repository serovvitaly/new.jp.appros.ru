<?php

/**
 * Тестирование Продуктов
 * @author Vitaly Serov
 */
class ProductsTest extends TestCase
{
    /**
     * @dataProvider getProductsParams
     * @param $params
     * @throws Exception
     */
    public function testMakeProduct($params)
    {
        \App\BusinessLogic\BusinessLogicProvider::makeProduct($params);
    }

    public function getProductsParams()
    {
        //
    }
}