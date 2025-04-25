<?php

namespace App\Models;

use App\Http\Controllers\Dashboard\AdminController;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User;
use Illuminate\Notifications\Notifiable;
class Admin extends User
{
    use HasFactory, Notifiable;
    protected $fillable = [
        'name',
        'username',
        'password',
        'phone_number',
        'status',
        'super_admin',
        'email',
        'store_id',
    ];

    public function roles()
    {
        return $this->morphToMany(Role::class, 'authorizable', 'role_users');
    }

    public function hasAbility($ability)
    {
        $denied = $this->roles()->whereHas('abilities', function (Builder $builder) use ($ability) {
            $builder->where('ability', $ability)
                ->where('type', 'deny');
        })->exists();

        if ($denied) {
            return false;
        }

        return $this->roles()->whereHas('abilities', function (Builder $builder) use ($ability) {
            $builder->where('ability', $ability)
                ->where('type', 'allow');
        })->exists();

    }

   
}
