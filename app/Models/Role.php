<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
    use SoftDeletes;

	CONST ACTIVE = 1;
	CONST INACTIVE = 0;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 
        'is_active'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'deleted_at'
    ];


    /**
     * The attributes casts.
     *
     * @var array
     */
    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Scope a query to only include active roles.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeIsActive($query)
    {
        return $query->whereIsActive(self::ACTIVE);
    }

    /**
     * Scope a query to only include role of a given type.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @param  mixed $type
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOfIsActive($query, $type)
    {
        return $query->whereIsActive($type);
    }

    /**
     * Get the users that associated with the role.
     * @return type
     */
    public function users()
    {
        return $this->belongsToMany('App\Models\User');
    }
    /**
     * The permissions that belong to the role.
     */
    public function permissions()
    {
        return $this->belongsToMany('App\Models\Permission');
    }

    /*
     * make dynamic attribute for human readable time
     *
     * @return string
     * */

    public function getHumansTimeAttribute() {
        return \Carbon\Carbon::parse($this->created_at)->diffForHumans();
    }
}
