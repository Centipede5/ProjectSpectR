<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        'title', 'slug', 'body', 'user_id',
    ];

    public function owner()
    {
        return $this->belongsTo(User::class);
    }

    // Using Eloquent Local Scopes here. Great for reusing Queries.
    // These are Called with Post::published() and Post::unpublished()
    // https://laravel.com/docs/master/eloquent#query-scopes
    /**
     * @param $query
     * @return mixed
     */
    public function scopePublished($query)
    {
        return $query->where('published', true);
    }

    public function scopeUnpublished($query)
    {
        return $query->where('published', false);
    }
}
