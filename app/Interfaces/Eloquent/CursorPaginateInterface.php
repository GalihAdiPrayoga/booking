<?php

namespace App\Interfaces\Eloquent;

use Illuminate\Http\Request;
use Illuminate\Pagination\CursorPaginator;

interface CursorPaginateInterface
{
    /**
     * Handle paginate data event from models.
     *
     * @param int $perPage
     * @param string[] $columns
     * @param string $cursorName
     * @param string|null $cursor
     * @param Request $request
     * @return CursorPaginator
     */

    public function cursorPaginate(int $perPage = 10, array $columns = ['*'], string $cursorName = 'cursor', $cursor = null, Request $request): CursorPaginator;
}
