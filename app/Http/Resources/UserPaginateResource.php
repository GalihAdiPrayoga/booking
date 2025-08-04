<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class UserPaginateResource extends ResourceCollection
{
    protected array $paginate;

    public function __construct($resource, $paginate)
    {
        parent::__construct($resource);
        $this->paginate = $paginate;
    }

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data = $this->collection->map(function ($visit) {

            return [
                'id' => $this->id,
                'name' => $this->name,
                'email' => $this->email,
                'photo' => $this->photo ?? null,
                'role' => $this->role ?? null
            ];

        })->all();

        return [
            'data' => $data,
            'paginate' => $this->paginate,
        ];
    }
}
