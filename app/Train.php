<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Train extends Model
{
    use Uuids;
    /**
 * Indicates if the IDs are auto-incrementing.
 *
 * @var bool
 */
public $incrementing = false;

protected $fillable = [
    'train_id', 'train_no', 'arrival_time', 'departur_time', 'source', 'destination', 'train_name', 'train_type', 'train_frequency'
];
}
