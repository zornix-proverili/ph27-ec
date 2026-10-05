<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'cast' => [
                'email_verified_at' => 'datetime',
                'password' => 'hash',
            ],
        ];
    }

    // 注文とのリレーション（もし未定義であれば追加してください）
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    // ▼ ここを修正：public function を正しく記述しました
    public function interactWithPurchasedProduct(int $productId): bool
    {
        return $this->orders()
            ->whereHas('details', function ($query) use ($productId) {
                $query->where('product_id', $productId);
            })->exists();
    }
}