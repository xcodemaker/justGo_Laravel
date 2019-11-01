<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserDetails extends Model
{
    use Uuids;
    protected $table = 'user_details';
    /**
 * Indicates if the IDs are auto-incrementing.
 *
 * @var bool
 */
public $incrementing = false;

    public $timestamps = false;

    protected $fillable = [
    	'user_id', 'first_name', 'last_name', 'address', 'nic_or_passport', 'contact_number', 'profile_pic'
    ];

    public function user()
    {
        return $this->belongsTo('\App\User', 'user_id', 'id');
    }
}
