<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceServiceToken extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'team_id',
        'app_id',
        'access_token'
    ];

    use HasFactory;

    public function teams() {
        return $this->belongsTo(Team::class, 'id', 'team_id');
    }
}
