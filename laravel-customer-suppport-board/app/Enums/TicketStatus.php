<?php

namespace App\Enums;

use Spatie\Enum\Enum;

/**
 * @method static self CREATED()
 * @method static self ASSIGNED()
 * @method static self PROCESSING()
 * @method static self DONE()
 * @method static self CANTFIX()
 */
class TicketStatus extends Enum
{
    /**
     * @return string[]
     */
    protected static function values(): array
    {
        return [
            'CREATED' => 'created',
            'ASSIGNED' => 'assigned',
            'PROCESSING' => 'processing',
            'DONE' => 'done',
            'CANTFIX' => 'cantfix',
        ];
    }
    
    /**
     * @return string[]
     */
    public static function getValues(): array
    {
        return array_values(static::values());
    }
}

