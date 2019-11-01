<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements JWTSubject
{
    use  Notifiable;
    use Uuids;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_type', 'email', 'password',
    ];

    /**
 * Indicates if the IDs are auto-incrementing.
 *
 * @var bool
 */
public $incrementing = false;


    public function user_details()
    {
        return $this->belongsTo('\App\UserDetails','id','user_id')->select('user_id', 'first_name', 'last_name', 'address', 'nic_or_passport', 'contact_number', 'profile_pic');
    }

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function getJWTIdentifier()
        {
            return $this->getKey();
        }
    public function getJWTCustomClaims()
        {
            return [];
        }

        public function isAdmin(){

            if($this->user_type=='admin'){
                return true;
            }
            else{
                return false;
            }
        }
}
