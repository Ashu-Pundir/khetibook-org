<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\User;

class Crop extends Model
{
    use HasFactory, Notifiable, HasApiTokens;

    protected $guarded = [];

    public function user(){

        return $this->belongsTo(User::class);
    }
}
