<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    use HasFactory;

    public function projects()
    {
        return $this->hasMany(Project::class);
        //qui scrivo il nome della tabella collegata, in questo caso 'projects' perchè è il nome della tabella che contiene i progetti
    }

    protected $fillable = ['title', 'slug',];
}
