<?php

namespace Fazanis\LaravelAntibot\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AntibotLog extends Model
{
    use HasFactory;

    protected $fillable=[
        'ip',
        'bot_id',
        'user_agent',
        'visits',
    ];

    public function bot():BelongsTo
    {
        return $this->belongsTo(AntibotBotList::class,'bot_id', 'id');
    }
}
