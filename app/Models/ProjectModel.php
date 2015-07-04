<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectModel extends Model {

    public $table = 'projects';

	public function categories()
    {
        return $this->hasMany('\App\Models\CatalogModel', 'project_id');
    }

    public function pricing_grids()
    {
        return $this->belongsToMany('\App\Models\PricingGridModel', 'projects_pricing_grids', 'project_id', 'pricing_grid_id');
    }

}
