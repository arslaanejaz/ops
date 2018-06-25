<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class Form extends Model
{
    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'attr', 'status', 'project_id', 'link_id', 'iterator'];

    public function inputs()
    {
        return $this->embedsMany('App\Models\FormElements\Input');
    }
    public function selects()
    {
        return $this->embedsMany('App\Models\FormElements\Select');
    }
    public function textareas()
    {
        return $this->embedsMany('App\Models\FormElements\Textarea');
    }
    public function project()
    {
        return $this->belongsTo('App\Models\Project');
    }
    public function link()
    {
        return $this->belongsTo('App\Models\Link');
    }

    
}
