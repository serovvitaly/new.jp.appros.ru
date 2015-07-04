<?php namespace App\Models;

use Zizaco\Entrust\EntrustRole;

class Role extends EntrustRole {

    protected $fillable = ['name', 'description', 'display_name'];

    /**
     * Поле, которое выступает в роли text в модели Ext.data.TreeModel
     */
    public $tree_text_field = 'display_name';

}
