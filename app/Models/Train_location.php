<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Train_location extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'train_location';
    protected $primaryKey = 'train_location_id';
    protected $fillable = [
        'train_location_name' 
    ];

  
}
