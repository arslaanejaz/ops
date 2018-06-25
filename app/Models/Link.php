<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class Link extends Model
{
    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['uri', 'parent_link','title', 'type', 'scraped', 'scraped_time', 'level', 'iteration', 'project_id'];

    public function project()
	{
		return $this->belongsTo('App\Models\Project');
	}

    public function pageSpeed()
    {
        return $this->belongsTo('App\Models\PageSpeed');
    }

	public function forms()
	{
		return $this->hasMany('App\Models\Form');
	}
	
}
