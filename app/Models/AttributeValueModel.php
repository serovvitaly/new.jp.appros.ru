<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AttributeValueModel extends Model {

    public $timestamps = false;

    public $table = 'attribute_values';

    protected $fillable = ['attribute_id', 'value', 'product_id'];

}
