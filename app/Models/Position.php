<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Position extends Model
{
    use HasFactory, HasUuids;

    protected $guarded = [];

    public function departement()
    {
        return $this->belongsTo(Departement::class);
    }
    

    public function userDepartementPosition()
    {
        return $this->hasMany(UserDepartementPosition::class);
    }
}
