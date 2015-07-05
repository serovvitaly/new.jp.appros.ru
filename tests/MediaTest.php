<?php

use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Тестирование работы с медиа материалами
 * @author Vitaly Serov
 */
class MediaTest extends TestCase {

    /**
     * Загрузка картинки
     */
    public function testLoadImage()
    {
        $product_model = \App\BusinessLogic\Models\Product::first();

        if (!$product_model) {
            return;
        }

        \Session::start();

        $this->call('POST', $this->getFullUrl('/seller/media/upload'),
            [
                'product_id' => $product_model->id,
                '_token' => \Session::token()
            ],
            [],
            [
                'files' => new UploadedFile(
                    base_path() . '/storage/app/media/test.jpg',
                    'test.jpg'
                )
            ]
        );

        //echo "\n1.", csrf_token(), "\n2.", Session::token(), "\n";

        //$this->assertEquals($response->getStatusCode(), 200);

        //\Storage::put('test.log', $response->getContent());

        //file_put_contents('/var/www/jp.appros.ru/public/test.php', json_encode($response->original));

        $this->assertResponseOk();

        //var_dump( $response->getContent() );
    }

}