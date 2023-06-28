<?php

declare(strict_types=1);

namespace BRCas\CA\Responses;

use BRCas\CA\Interfaces\ItemInterface;

class ItemResponse
{
    public static function response(ItemInterface $pagination)
    {
        return [
            'items' => $pagination->items(),
            'total' => $pagination->total(),
        ];
    }
}
