<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class forget_password extends Model
{
    use HasFactory;
    protected $table = 'password_reset_tokens';
    protected $fillable = [
        'email',
        'token',
    ];
    const UPDATED_AT = null;
}
