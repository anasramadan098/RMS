<?php

namespace App\Enums;

enum UserRole: string
{

    case OWNER = 'owner';
    case EMPLOYEE = 'employee';
    // case ADMIN = 'admin';
    case MANAGER = 'manager';
    case CASHIER = 'cashier';
    // case KITCHEN = 'kitchen';
    // case WAITER = 'waiter';

    /**
     * Get all role values
     */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    /**
     * Get role label for display
     */
    public function label(): string
    {
        return match($this) {
            self::OWNER => 'Owner',
            self::EMPLOYEE => 'Employee',
            // self::ADMIN => 'Admin',
            self::MANAGER => 'Manager',
            self::CASHIER => 'Cashier',
            // self::KITCHEN => 'Kitchen',
            // self::WAITER => 'Waiter',
        };
    }
}
