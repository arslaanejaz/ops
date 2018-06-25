<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class PageSpeed extends Model
{
    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['data', 'link_id'];



    
}
