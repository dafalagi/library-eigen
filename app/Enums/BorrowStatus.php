<?php

namespace App\Enums;

enum BorrowStatus: string
{
    case Borrowed = 'Borrowed';
    case Returned = 'Returned';
}
