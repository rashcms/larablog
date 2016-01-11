<?php

namespace Websanova\Larablog\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
	protected $dates = ['published_at'];

	public $guarded = [];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        
        $this->table = config('larablog.table.prefix') . '_posts';
    }

    public function tags()
    {
        return $this->belongsToMany('Websanova\Larablog\Models\Tag', config('larablog.table.prefix') . '_post_tag');
    }

    public function scopeSearch($q, $search)
    {
        return $q->whereRaw("MATCH (`title`, `body`) AGAINST (?)" , [$search]);
    }

    public function getUrlAttribute()
    {
        return config('app.url') . $this->slug;
    }

    public function getMetaAttribute($val)
    {
    	return json_decode($val);
    }
}
