<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{	
	/**
	 * [$guarded description]
	 * @var array
	 */
    protected $guarded = [];

    /**
     * [Path of Book url]
     * @return [type] [description]
     */
    public function path()
    {
        return '/books/'.$this->id;
    }

    public function setAuthorIdAttribute($author)
    {
        $this->attributes['author_id'] = (Author::firstOrCreate([
            'name' => $author,
        ]))->id;
    }
}
