<?php

namespace Fazanis\LaravelAntibot\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AntibotBotList extends Model
{
    use HasFactory;

    protected $fillable=['bot_name','is_block'];

    public function bots()
    {
        return $this->hasMany(AntibotLog::class,'bot_id','id');
    }
}
