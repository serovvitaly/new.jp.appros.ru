<?php namespace App\Http\Controllers;


class CatalogController extends Controller {

    public function getIndex()
    {
        \Blade::setEscapedContentTags('[[', ']]');
        \Blade::setContentTags('[[[', ']]]');

        return view('tezo/index');

        $sphinx = \Sphinx\SphinxClient::create();

        // Подсоединяемся к Sphinx-серверу
        $sphinx->setServer('127.0.0.1', 3312);

        // Совпадение по любому слову
        $sphinx->setMatchMode(\Sphinx\SphinxClient::SPH_MATCH_ANY);

        // Результаты сортировать по релевантности
        //$sphinx->setSortMode(\Sphinx\SphinxClient::SPH_SORT_EXTENDED);

        // Задаем полям веса (для подсчета релевантности)
        //$sphinx->setFieldWeights(array ('name' => 20, 'description' => 10));

        $sphinx->addQuery(\Input::get('q', ''), '*');

        $res = $sphinx->runQueries();

        if (!$res) {
            return [false];
        }

        return $res;

        $offset = intval(\Input::get('start', 0));
        $limit = intval(\Input::get('limit', 40));

        $products_in_purchases = app('BusinessLogic')->getProductsInPurchases();

        return view('catalog.index', ['products_in_purchases' => $products_in_purchases]);
    }

}