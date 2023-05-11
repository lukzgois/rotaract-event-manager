<?php

namespace App\Enums;

enum PaymentType: string
{
    case PIX = 'pix';
    case CREDIT_CARD = 'credit_card';
}
