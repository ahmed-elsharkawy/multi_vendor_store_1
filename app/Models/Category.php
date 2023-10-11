<?php

namespace App\Models;

use App\Rules\Filter;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Validation\Rule;

class Category extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name', 'slug', 'description', 'parent_id', 'image', 'status'];

    public function products(){
        return $this->hasMany(Product::class);
    }

    public function parent(){
        return $this->belongsTo(Category::class, 'parent_id', 'id')->withDefault(['name' => 'Main Category']);
    }

    public function children(){
        return $this->hasMany(Category::class, 'parent_id', 'id');
    }

    public function scopeFilter(Builder $builder, $filters){

        $builder->when($filters['name'] ?? false, function($builder, $value){
            $builder->where('name', 'LIKE', "%{$value}%");
        });

        $builder->when($filters['status'] ?? false, function($builder, $value){
            $builder->where('status', $value);
        });

        // if($name = request()->query('name')){
        //     $query->where('name', 'LIKE', "%{$name}%");
        // }
        // if($status = request()->query('status')){
        //     $query->whereStatus($status);
        // }
    }

    public static function rules($id = 0){
        return [
            'name' => [
                'required',
                'min:3',
                'max:100',
                Rule::unique('categories', 'name')->ignore($id),
                // function($attribute, $value, $fails){
                //     if(strtolower($value) == 'laravel'){
                //         $fails('the '. $attribute. ' '. $value. ' is Forbidden!');
                //     }
                // }

                // new Filter(['laravel', 'php', 'html']),

                'filter:laravel,php,html'
            ],
            'parent_id' => 'nullable|int|exists:categories,id',
            'description' => 'max:255',
            'image' => 'mimes:png,jpg,jpeg|max:1024000',
            'status' => 'in:active,inactive'
        ];
    }
}
