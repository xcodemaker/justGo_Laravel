<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TicketDetails extends Model
{
    use Uuids;
    /**
 * Indicates if the IDs are auto-incrementing.
 *
 * @var bool
 */
public $incrementing = false;

protected $fillable = [
    'price', 'class', 'date', 'distance', 'qr_code', 'time', 'source', 'destination'
];
}
