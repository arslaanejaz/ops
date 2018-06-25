<?php

namespace App\Models\FormElements;

use Jenssegers\Mongodb\Eloquent\Model;

class Textarea extends Model
{
    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['name','attr', 'status'];

    public function test_values()
    {
        return $this->hasMany('App\Models\TestValues');
    }

	
}
