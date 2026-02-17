<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Shipment extends Model
{
    protected $fillable = [
        'tracking_number',
        'sender_name',
        'sender_address',
        'receiver_name',
        'receiver_address',
        'status',
    ];
    public function statusLogs()
    {
        return $this->hasMany(StatusLog::class);
    }

    public function getStatusBadgeAttribute()
{
    $badge = match($this->status) {
        'Pending' => 'bg-warning',
        'In Transit' => 'bg-info',
        'Delivered' => 'bg-success',
    };

    return '<span class="badge '.$badge.'">'.$this->status.'</span>';
}


}
