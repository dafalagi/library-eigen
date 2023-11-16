<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function scopeFilter($query, array $filters)
    {
        $query->when(
                $filters['search'] ?? false, fn ($query, $search) 
                => $query->where('code', 'like', '%' . $search . '%')
                ->orWhere('name', 'like', '%' . $search . '%')
            )->when(
                $filters['code'] ?? false, fn ($query, $code) 
                => $query->where('code', 'like', '%' . $code . '%')
            )->when(
                $filters['name'] ?? false, fn ($query, $name) 
                => $query->where('name', 'like', '%' . $name . '%')
            );
    }

    public function checkIfMemberIsPenalized($memberId)
    {
        $member = Member::where('id', $memberId)->first();

        if ($member->penalty == 0) {
            return false;
        }
        
        return true;
    }

    public function PenalizeMember($memberId)
    {
        $member = Member::where('id', $memberId)->first();

        $member->penalty = 1;

        $member->save();

        return true;
    }

    public function borrows()
    {
        return $this->hasMany(Borrow::class);
    }
}
