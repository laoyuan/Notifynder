<?php
namespace Fenos\Tests\Models;

use Fenos\Notifynder\Notifable;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use Notifable;

    // Never do this
    protected $fillable = [
        'id',
        'name',
        'surname',
    ];
}