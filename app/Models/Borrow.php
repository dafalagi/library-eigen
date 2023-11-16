<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Borrow extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function scopeFilter($query, array $filters)
    {
        $query->when(
                $filters['search'] ?? false, function ($query, $search) {
                    $query->whereHas('member', function ($query) use ($search) {
                        $query->where('name', 'like', '%' . $search . '%');
                    })->orWhereHas('book', function ($query) use ($search) {
                        $query->where('title', 'like', '%' . $search . '%');
                    });
                }
            )
            ->when($filters['status'] ?? false, function ($query, $status) {
                $query->where('status', $status);
            });
    }

    public function checkHowManyBooksAreBorrowedByMember($memberId)
    {
        $borrow = Borrow::where('member_id', $memberId)->where('status', 'Borrowed')->count();

        return $borrow;
    }

    public function checkIfBookIsAvailable($bookId)
    {
        $book = Borrow::where('book_id', $bookId)->where('status', 'Borrowed')->first();

        if ($book) {
            return false;
        }

        return true;
    }

    public function checkIfReturnDateIsPassed($borrowId)
    {
        $borrow = Borrow::where('id', $borrowId)->first();

        if ($borrow->return_date > now()) {
            return true;
        }

        return false;
    }

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function book()
    {
        return $this->belongsTo(Book::class);
    }
}
