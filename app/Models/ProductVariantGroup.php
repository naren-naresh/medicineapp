<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariantGroup extends Model
{
    use HasFactory;
    protected  $guarded = [];
    public $timestamps = false;
    public static function getProductVariantOptionValue($product_id, $product_variant_id)
    {
        $result = self::where('product_id', $product_id)
                      ->where('product_variant_id', $product_variant_id)
                      ->value('product_variant_option_value_id');
        return $result;
    }
}
