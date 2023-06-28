<?php

declare(strict_types=1);

namespace BRCas\CA\Responses;

use BRCas\CA\Interfaces\PaginationInterface;

class PaginationResponse
{
    public static function response(PaginationInterface $pagination)
    {
        return [
            'items' => $pagination->items(),
            'total' => $pagination->total(),
            'last_page' => $pagination->lastPage(),
            'first_page' => $pagination->firstPage(),
            'current_page' => $pagination->currentPage(),
            'per_page' => $pagination->perPage(),
            'to' => $pagination->to(),
            'from' => $pagination->from(),
        ];
    }
}
