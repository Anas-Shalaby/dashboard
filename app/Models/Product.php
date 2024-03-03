<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class Product extends Model implements TranslatableContract
{
    use HasFactory ,Translatable;

    protected $guarded= [];
    public $translatedAttributes = ['name' , 'description'];



    protected $appends = ['image_path' , 'profit_percent' , 'discount_count'];


    public function category() {
        return $this->belongsTo(Category::class);
    }// end of category

    public function getImagePathAttribute(){
        return asset('uploads/products_images/'.$this->image);
    }

    public  function  getDiscountCountAttribute(){

        $discount = ($this->sale_price  * $this->discount )/ 100;

        return $discount;


    }

    public  function getProfitPercentAttribute(){
        $profit = $this->sale_price - $this->purchase_price;
        $profit_percent = ($profit * 100) / $this->purchase_price;

        return number_format($profit_percent,2);
    }

    public function orders(){
        $this->belongsToMany(Order::class,'product_order');
    }

}
