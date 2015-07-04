<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WidgetModel extends Model {

    public $table = 'widgets';

    protected $fillable = ['name', 'description', 'handler', 'region', 'status', 'position'];

    public $grid_columns = [
        [
            'text' => 'ID',
            'dataIndex' => 'id',
            'width' => 50
        ],
        [
            'text' => 'Наименование',
            'dataIndex' => 'name',
            'width' => 400
        ],
        [
            'text' => 'Регион',
            'dataIndex' => 'region',
            'width' => 150
        ],
        [
            'text' => 'Позиция',
            'dataIndex' => 'position',
            'width' => 100
        ],
        [
            'text' => 'Обработчик',
            'dataIndex' => 'handler',
            'flex' => 1
        ],
    ];

}
