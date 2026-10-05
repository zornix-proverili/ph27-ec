<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'description',
        'stock',
        'category_id',
        'image',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // レビューとのリレーション
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    // 平均評価を計算するメソッド（★表示用）
    public function averageRating()
    {
        if ($this->reviews()->count() === 0) {
            return 0.0;
        }
        return round($this->reviews()->avg('rating'), 1);
    }

    public function imageUrl()
    {
        if ($this->image) {
            return asset('storage/' . $this->image);
        }
        return asset('images/no-image.png');
    }

    // お気に入り登録しているユーザーとのリレーション
    public function favoritedUsers()
    {
        return $this->belongsToMany(User::class, 'favorites', 'product_id', 'user_id')->withTimestamps();
    }
}