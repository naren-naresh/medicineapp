<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductVariant extends Model
{
    use HasFactory, SoftDeletes;
    protected $dates = ['deleted_at'];

    protected  $guarded = [];

    public function getOptionValue($variant_id,$option_id){
           $option_value_id = ProductVariantGroup::where('product_variant_id',$variant_id)->where('product_variant_option_id',$option_id)->value('product_variant_option_value_id');
        return ProductVariantOptionValue::where('id',$option_value_id)->withTrashed()->value('variant_option_values');
    }
}
