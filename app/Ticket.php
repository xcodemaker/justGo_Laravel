<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use Uuids;
    /**
 * Indicates if the IDs are auto-incrementing.
 *
 * @var bool
 */
    public $incrementing = false;
    protected $fillable = [
    'user_id', 'train_id', 'ticket_details_id'
    ];

    public function train()
    {
        return $this->belongsTo('\App\Train','train_id','id')->select('id','train_id', 'train_no', 'arrival_time', 'departur_time', 'source', 'destination', 'train_name', 'train_type', 'train_frequency');
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id', 'id')->select('id','user_type','email');
    
    }

    public function ticket_details()
    {
        return $this->belongsTo('\App\TicketDetails','ticket_details_id','id')->select('id','price', 'class AS class_type', 'date', 'distance', 'qr_code', 'time', 'source', 'destination');
    }

}
