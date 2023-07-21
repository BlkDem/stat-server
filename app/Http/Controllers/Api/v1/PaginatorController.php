<?php

namespace App\Http\Controllers\Api\v1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PaginatorController extends Controller
{
        /**
     * Paginate - create a Paginator array
     *
     * @param  int $itemsCount
     * @param  int $itemsPerPage
     * @param  int $currentPage
     * @return array
     */
    public static function Paginate($itemsCount=0, $itemsPerPage=5, $currentPage=1)
    {
        $PagesCount = (int)($itemsCount / $itemsPerPage);

        if (($PagesCount * $itemsPerPage) < $itemsCount) $PagesCount++;

        $NewPage = ($currentPage > $PagesCount)?$PagesCount:(int)$currentPage;
        if ($NewPage == 0) $NewPage++;

        return array(
            'RecordsCount' => $itemsCount,
            'PagesCount' => $PagesCount,
            'ItemsPerPage' => $itemsPerPage,
            'CurrentPage' => $NewPage
        );
    }

}
