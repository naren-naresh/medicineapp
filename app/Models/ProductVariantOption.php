<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductVariantOption extends Model
{
    use HasFactory, SoftDeletes;
    protected $dates = ['deleted_at'];

    protected  $guarded = [];
    public static function getProductVariantValue($product_id,$id)
    {
        $result = self::where('product_id',$product_id)
                      ->where('id',$id)
                      ->value('variant');
        return $result;
    }
}
