<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'email',
    ];

    /**
     * Undocumented function
     *
     * @return void
     */
    public function events()
    {
        return $this->belongsToMany('App\Event');
    }
}
