<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductVariantOptionValue extends Model
{
    use HasFactory, SoftDeletes;
    protected $dates = ['deleted_at'];

    protected  $guarded = [];
    public static function getProductVariantOptionValue($product_id,$product_variant_id,$id)
    {
        $result = self::where('variant_option_id', $product_variant_id)
                      ->where('product_id',$product_id)
                      ->where('id',$id)
                      ->value('variant_option_values');
        return $result;
    }
}
