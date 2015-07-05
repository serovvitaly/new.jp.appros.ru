<?php

/**
 * Тестирование Закупок
 * @author Vitaly Serov
 */
class PurchaseTest extends TestCase {

    static $purchase_id;

    static $products_appended_ids_arr;

    /**
     * Создание закупки
     */
    public function testCreatePurchase()
    {
        $purchase_name = 'Наименование тестовой закупки';
        $purchase_description = 'Описание тестовой закупки';

        $pricing_grid_id = 12;
        $expiration_time = date('Y-m-d H:i:s', (time() + 3600 * 24 * 7));

        $purchase_model = \App\Models\PurchaseModel::create([
            'name' => $purchase_name,
            'description' => $purchase_description,
            'pricing_grid_id' => $pricing_grid_id,
            'expiration_time' => $expiration_time,
        ]);

        $this->assertInstanceOf('\App\Models\PurchaseModel', $purchase_model);

        $this->assertEquals($purchase_name, $purchase_model->name);

        $this->assertEquals($purchase_description, $purchase_model->description);

        $this->assertEquals($pricing_grid_id, $purchase_model->pricing_grid_id);

        $this->assertEquals($expiration_time, $purchase_model->expiration_time);

        self::$purchase_id = (int) $purchase_model->id;
    }

    /**
     * Добавление продукта
     */
    public function testAttachProduct()
    {
        /**
         * @var $purchase_model \App\Models\PurchaseModel
         */
        $purchase_model = \App\Models\PurchaseModel::find(self::$purchase_id);

        $this->assertInstanceOf('\App\Models\PurchaseModel', $purchase_model);

        $products_count = rand(2, 5);

        $products_models_arr = \App\BusinessLogic\Models\Product::take($products_count)->get();

        //$this->assertEquals(count($products_models_arr), $products_count);

        $products_appended_ids_arr = [];

        foreach ($products_models_arr as $product_model) {
            $product_appended = $purchase_model->appendProduct($product_model);
            $this->assertTrue($product_appended);
            $products_appended_ids_arr[] = $product_model->id;
        }

        $products_in_purchase_arr = \DB::table($purchase_model->products()->getTable())
            ->where('purchase_id', '=', $purchase_model->id)
            ->get(['product_id']);

        $this->assertNotEmpty($products_in_purchase_arr);

        $products_in_purchase_ids_arr = [];

        foreach ($products_in_purchase_arr as $product_in_purchase_obj) {
            $products_in_purchase_ids_arr[] = $product_in_purchase_obj->product_id;
        }

        foreach ($products_appended_ids_arr as $product_appended_id) {
            $this->assertContains($product_appended_id, $products_in_purchase_ids_arr);
        }

        self::$products_appended_ids_arr = $products_appended_ids_arr;
    }

    /**
     * Удаление продукта
     */
    public function testDetachProduct()
    {
        /**
         * @var $purchase_model \App\Models\PurchaseModel
         */
        $purchase_model = \App\Models\PurchaseModel::find(self::$purchase_id);

        $this->assertInstanceOf('\App\Models\PurchaseModel', $purchase_model);

        $this->assertNotEmpty(self::$products_appended_ids_arr);

        foreach (self::$products_appended_ids_arr as $product_appended_id) {
            $product_removed = $purchase_model->removeProduct($product_appended_id);
            $this->assertTrue($product_removed);
        }

        $products_in_purchase_arr = \DB::table($purchase_model->products()->getTable())
            ->where('purchase_id', '=', $purchase_model->id)
            ->get(['product_id']);

        $this->assertEmpty($products_in_purchase_arr);
    }

    /**
     * Прикрепление ценовых колонок
     */
    public function testAttachPricingGridColumns()
    {
        //
    }

    /**
     * Открепление ценовых колонок
     */
    public function testDetachPricingGridColumns()
    {
        //
    }

    /**
     * Проверка цен на продукты в закупке
     */
    public function testCheckPrices()
    {
        //
    }

    /**
     * Удаление закупки
     */
    public function testRemovePurchase()
    {
        $this->assertGreaterThan(0, self::$purchase_id);

        \App\Models\PurchaseModel::destroy(self::$purchase_id);

        $purchase_model = \App\Models\PurchaseModel::find(self::$purchase_id);

        $this->assertNull($purchase_model);
    }
}