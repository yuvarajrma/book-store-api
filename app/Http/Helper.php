<?php

namespace App\Http;

class Helper
{
    public static function pagination($page, $totalRecords, $items_per_page = 10)
    {
        return [
            'currentPage' => (int)$page,
            'totalPage' => ceil($totalRecords / $items_per_page),
            'currentRecords' => $page * $items_per_page > $totalRecords ? $totalRecords : $page * $items_per_page,
            'totalRecords' => $totalRecords,
            'recordsPerPage' => $items_per_page
        ];
    }
}