<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class TestValues extends Model
{
    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['scope', 'value', 'item_id'];

    public function input()
    {
        return $this->belongsTo('App\Models\FormElements\Input');
    }

    
}
