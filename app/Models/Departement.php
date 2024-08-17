<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Departement extends Model
{
    use HasFactory, HasUuids;

    protected $guarded = [];

    public function userDepartementPosition()
    {
        return $this->hasMany(UserDepartementPosition::class);
    }
}
