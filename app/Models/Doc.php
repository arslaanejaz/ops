<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class Doc extends Model
{
    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['url', 'request', 'method', 'response', 'project_id'];

    
}
