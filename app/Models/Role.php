<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = [
        'name'
    ];

    public function users()
    {
        return $this->morphedByMany(
            User::class,
            'authorizable',
            'role_users',
            'role_id',
            'authorizable_id',
            'id',
            'id'
        );
    }

    public function admins()
    {
        return $this->morphedByMany(
            Admin::class,
            'authorizable',
            'role_users',
            'role_id',
            'authorizable_id',
            'id',
            'id'
        );
    }

    public function abilities()
    {
        return $this->hasMany(RoleAbility::class);

        //$abilities = RoleAbility::where('role_id', $this->id)
        //   ->where('type', 'allow')->pluck('ability')->toArray();

        // return implode('/', $abilities);

    }

    public function hasAbility($ability)
    {

        $result = $this->abilities()
            ->where('ability', $ability)->first();
        return $result ? $result->type : "";

    }



}
