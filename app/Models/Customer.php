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
        $newGroup = CustomerGroup::whereIn('name', $groups)->pluck('id')->toArray();
        $this->groups()->sync($newGroup);
    }
}
