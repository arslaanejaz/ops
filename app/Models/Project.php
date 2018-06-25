<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class Project extends Model
{
    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'uri', 'login', 'host', 'skip_uri', 'skip_repeat', 'skip_repeat_form', 'x_headers', 'testing'];

    
}
