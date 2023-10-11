<?php

namespace App\Models;

use App\Models\Scopes\StoreScope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Support\Str;

class Product extends Model
{
    public $timestamps = false;

    protected $guarded = ['id'];

    use HasFactory, SoftDeletes;

    protected static function booted()
    {
        static::addGlobalScope('store', new StoreScope());
    }

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function store(){
        return $this->belongsTo(Store::class);
    }

    public function tags(){
        return $this->belongsToMany(Tag::class);
    }

    public function scopeActive(Builder $builder){
        return $builder->where('status', '=', 'active');
    }

    // image_url attribute accessor
    public function getImageUrlAttribute(){
        if(!$this->image){
            return 'https://sudbury.legendboats.com/resource/defaultProductImage';
        }
        if(Str::startsWith($this->image, ['http://', 'https://'])){
            return $this->image;
        }
        return asset('storage/'.$this->image);
    }

    // sale_percent attribute accessor
    public function getSalePercentAttribute(){
        if(!$this->compare_price){
            return null;
        }
        $value = round(($this->compare_price - $this->price) / 100, 0);
        return $value;
    }
}
