<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory, SoftDeletes;
    protected $dates = ['deleted_at'];

    protected  $guarded = [];

    public function user(): HasOne
    {
        return $this->hasOne(User::class,'id');
    }
    public function parent(){
        return $this->belongsTo(self::class,'id');
    }
    public function children(){
        return $this->hasOne(self::class,'id');
    }
}
