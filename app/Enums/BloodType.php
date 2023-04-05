<?php
namespace App\Enums;

enum BloodType: string
{
    case APositive = 'A+';
    case ANegative = 'A-';
    case BPositive = 'B+';
    case BNegative = 'B-';
    case OPositive = 'O+';
    case ONegative = 'O-';
    case ABPositive = 'AB+';
    case ABNegative = 'AB-';

    public static function toOptionsArray(): array
    {
        return array_combine(
            array_column(BloodType::cases(), 'value'),
            array_column(BloodType::cases(), 'value'),
        );
    }
}
