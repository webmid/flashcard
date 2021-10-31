<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Practice extends Model
{
    use HasFactory;
    protected $table = 'practices';
    protected $guarded = ['id'];
    protected $hidden = ['id'];

    public function flashCard()
    {
        return $this->belongsTo(FlashCard::class, 'card_id', 'id');
    }
}
