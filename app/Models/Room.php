<?php

namespace App\Models;

use App\Enums\RoomEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 *
 */
class Room extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'room';
    protected $fillable = [
        'name',
        'room_no',
        'address',
        'type',
        'image',
        'video',
        'panorama'
    ];
    protected $casts = [
        'type' => RoomEnum::class,
    ];
    protected $appends = [
        'reserved'
    ];

    /**
     * @return BelongsToMany
     */
    public function reluser(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'reserve', 'room_id', 'user_id')
            ->withPivot('room_id', 'user_id', 'price', 'breakfast');
    }

    /**
     * @return HasMany
     */
    public function relreserve(): HasMany
    {
        return $this->hasMany(Reserve::class, 'room_id', 'id');
    }

    /**
     * @return string
     */
    public function getReservedAttribute(): string
    {
        if ($this->relreserve()->where('room_id', $this->id)->first())
            return 'true';
        else
            return 'false';
    }

    /**
     * @return mixed
     */
    public function getPriceAttribute(): mixed
    {
        return $this->relreserve()->where('room_id', $this->id)->first()->price;
    }

    /**
     * @return mixed
     */
    public function getFromDateAttribute(): mixed
    {
        return $this->relreserve()->where('room_id', $this->id)->first()->from_date;
    }

    /**
     * @return mixed
     */
    public function getToDateAttribute(): mixed
    {
        return $this->relreserve()->where('room_id', $this->id)->first()->to_date;
    }
}
