<?php

namespace Database\Seeders;

use App\Enums\BorrowStatus;
use App\Models\Borrow;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BorrowSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Borrow::create([
            'member_id' => 1,
            'book_id' => 1,
            'borrow_date' => '2023-11-15',
            'status' => BorrowStatus::Borrowed,
        ]);

        Borrow::factory(2)->create();
    }
}
