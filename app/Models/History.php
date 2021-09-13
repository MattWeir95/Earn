<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    use HasFactory;

    protected $table = "histories";
    public $timestamps = false;
    protected $primary_key = 'id';

    protected $attributes = [
        'flagged' => false,
        'approved' => false
    ];

    protected $fillable = [
        'team_user_id',
        'start_time',
        'end_time',
        'total_commission',
        'flagged',
        'approved'
    ];

    public function teamUser() {
        return $this->belongsTo(TeamUser::class);
    }

}
