<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    public function type()
    { //qui scrivo il nome della tabella collegata, in questo caso 'types'
        return $this->belongsTo(Type::class);
    }

    protected $fillable = ['title', 'slug', 'image'];
}
