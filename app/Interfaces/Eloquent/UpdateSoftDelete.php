<?php

namespace App\Interfaces\Eloquent;

interface UpdateSoftDelete
{
    /**
     * Handle show method and update data instantly from soft deleted models.
     *
     * @param mixed $id
     * @param array $data
     *
     * @return mixed
     */

    public function updateSoftDelete(mixed $id, array $data): mixed;
}
