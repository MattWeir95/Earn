<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'team_user_id',
        'service_name',
        'service_cost',
        'commission_paid',
        'date'
    ];

    public function teamUser() {
        return $this->belongsTo(TeamUser::class);
    }
}
