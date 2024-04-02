<?php

namespace App\Enums;

enum UserRole: string
{
    case Administrator = 'admin';
    case User = 'user';
}
