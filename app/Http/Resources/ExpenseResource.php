<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class ExpenseResource extends JsonResource
{
    protected array $dateFields = ['created_at', 'updated_at'];
    protected array $basicFields = ['title', 'amount'];

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
        
        collect($this->dateFields)->each(function ($dateField) use (&$data) {
            if (isset($this->{$dateField})) {
                $data[$dateField] = Carbon::parse($this->{$dateField})->toDayDateTimeString();
            }
        });

        
        if ($this->relationLoaded('category') && $this->category) {
            $data['category'] = $this->category->name;
        }

        return $data;
    }
}