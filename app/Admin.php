<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{

    protected $table = 'admin';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function roles()
    {
      return $this->belongsToMany(AdminRoles::class);
    }
   /**

    * @param string|array $roles

    */

    public function authorizeRoles($roles)

    {

      if (is_array($roles)) {

          return $this->hasAnyRole($roles) || 
                 abort(401, 'This action is unauthorized.');

      }

      return $this->hasRole($roles) || 
             abort(401, 'This action is unauthorized.');

    }

    /**

    * Check multiple roles

    * @param array $roles

    */

    public function hasAnyRole($roles)

    {

      return null !== $this->roles()->whereIn('name', $roles)->first();

    }

    /**

    * Check one role

    * @param string $role

    */

    public function hasRole($role)

    {

      return null !== $this->roles()->where('name', $role)->first();

    } 
}
