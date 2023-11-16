<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function scopeFilter($query, array $filters)
    {
        $query->when(
                $filters['search'] ?? false, fn ($query, $search) 
                => $query->where('code', 'like', '%' . $search . '%')
                ->orWhere('title', 'like', '%' . $search . '%')
                ->orWhere('author', 'like', '%' . $search . '%')
                ->orWhere('stock', 'like', '%' . $search . '%')
            )->when(
                $filters['code'] ?? false, fn ($query, $code) 
                => $query->where('code', 'like', '%' . $code . '%')
            )->when(
                $filters['title'] ?? false, fn ($query, $title) 
                => $query->where('title', 'like', '%' . $title . '%')
            )->when(
                $filters['author'] ?? false, fn ($query, $author) 
                => $query->where('author', 'like', '%' . $author . '%')
            )->when(
                $filters['stock'] ?? false, fn ($query, $stock) 
                => $query->where('stock', 'like', '%' . $stock . '%')
            );
    }

    public function borrows()
    {
        return $this->hasMany(Borrow::class);
    }
}
