<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 *
 */
class Reserve extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'reserve';
    protected $fillable = [
        'user_id',
        'room_id',
        'price',
        'breakfast',
        'from_date',
        'to_date',
    ];


    /**
     * @return BelongsTo
     */
    public function relroom(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }

    /**
     * @return BelongsTo
     */
    public function reluser(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

}
