<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AttributeModel extends Model {

    public $table = 'attributes';

    protected $fillable = ['name', 'title', 'attribute_group_id'];

}
