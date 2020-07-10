<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'date'
    ];

    /**
     * Undocumented function
     *
     * @return void
     */
    public function users()
    {
        return $this->belongsToMany('App\User');
    }
}
