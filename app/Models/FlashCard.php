<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FlashCard extends Model
{
    use HasFactory;
    protected $table='flashcards';
    protected $guarded = ['id'];
    protected $hidden = ['id'];

    public function practices()
    {
        return $this->hasMany(Practice::class, 'card_id', 'id');
    }
}
