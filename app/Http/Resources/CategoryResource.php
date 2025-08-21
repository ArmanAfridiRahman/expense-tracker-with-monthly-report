<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    protected array $basicFields = ['name', 'total'];

    /**
     * Summary of toArray
     * @param mixed $request
     */
    public function toArray($request): array
    {
        $data = [
            'id' => $this->id,
        ];

        collect($this->basicFields)
            ->each(function ($field) use (&$data) {
            if (isset($this->{$field})) {
                $data[$field] = $this->{$field};
            }
        });

        if (isset($this->expenses_count))
            $data['expenses_count'] = $this->expenses_count;

        if ($this->relationLoaded('expenses') && $this->expenses) {
            $data['expenses'] = ExpenseCollection::make($this->expenses);
        }

        return $data;
    }
}
