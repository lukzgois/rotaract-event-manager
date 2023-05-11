<?php

namespace App\Enums;

enum TicketBatch: string
{
    case FIRST_BATCH = 'first_batch';
    case SECOND_BATCH = 'second_batch';
    case THIRD_BATCH = 'third_batch';
    case CCO = 'cco';
}
