<?php

namespace App\Models;

use App\Models\User;
use App\Models\Category;
use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Article extends Model
{
    use HasFactory, Searchable;
    
    public function toSearchableArray()
    {
        $category = $this->category;
        $array = [
            'id'=> $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'category' => $this->category
        ];
        return $array;
    }

    protected $fillable = [
        'user_id',
        'category_id',
        'name',
        'description',
        'price',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function setAccepted($value)
    {
        $this->is_accepted = $value;
        $this->save();
        return true;
    }

    public static function toBeRevisionedCount()
    {
        return Article::where('is_accepted', null)->count();
    }
}
