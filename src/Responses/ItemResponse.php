<?php

declare(strict_types=1);

namespace BRCas\CA\Responses;

use BRCas\CA\Contracts\Items\ItemInterface;

class ItemResponse
{
    public static function response(ItemInterface $pagination): array
    {
        return [
            'items' => $pagination->items(),
            'total' => $pagination->total(),
        ];
    }
}
