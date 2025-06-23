<?php

namespace App\Order\Enums;

enum OrderStatus: string
{
    case Pending = 'PENDING';
    case Received = 'RECEIVED';
    case Cancelled = 'CANCELLED';

    public function label(): string
    {
        return match($this) {
            self::Pending => 'Pendiente',
            self::Received => 'Recibida',
            self::Cancelled => 'Cancelada',
        };
    }
}
