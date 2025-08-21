<?php

namespace App\Models;

use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Expense extends Model
{
    use HasFactory, Filterable;

    protected $fillable = ['user_id', 'category_id', 'title', 'amount', 'date'];

    /**
     * Summary of user
     * @return BelongsTo<User, Expense>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Summary of category
     * @return BelongsTo<Category, Expense>
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
