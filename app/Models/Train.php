<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Train extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'train';
    protected $primaryKey = 'train_id';
    protected $fillable = [
        'train_book_advert',
        'train_book_no',
        'train_date'
    ];

  
}
