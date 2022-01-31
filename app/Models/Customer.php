<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
    ];

    public function groups(): BelongsToMany
    {
        return $this->belongsToMany(CustomerGroup::class);
    }

    public function syncGroups(array $groups): void
    {
        $newGroup = CustomerGroup::query()->whereIn('name', $groups)->pluck('id')->all();
        $this->groups()->sync($newGroup);
    }

    /**
     * @param mixed[] $attributes
     * @return bool
     */
    public function fillAndSave(array $attributes): bool
    {
        $this->fill($attributes);
        return $this->save();
    }
}
