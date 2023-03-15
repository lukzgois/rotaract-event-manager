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
}
