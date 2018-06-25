<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class TestCase extends Model
{
    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'action', 'method', '__method', 'type', 'obj', 'options', 'project_id'];

    public function project()
    {
        return $this->belongsTo('App\Models\Project');
    }
    public function form()
    {
        return $this->belongsTo('App\Models\Form');
    }
    
}
