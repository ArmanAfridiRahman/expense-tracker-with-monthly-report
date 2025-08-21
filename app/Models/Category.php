<?php

namespace App\Models;

use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory, Filterable;

    protected $fillable = ['name'];

    /**
     * Summary of expenses
     * @return HasMany<Expense, Category>
     */
    public function expenses(): HasMany
    {
        return $this->hasMany(Expense::class);
    }
}
