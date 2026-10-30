<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Meeting extends Model
{
    protected $fillable = [
        'title',
        'description',
        'agenda',
        'start_at',
        'end_at',
        'room_id',
        'created_by',
        'attachments'
    ];

    // تحويل حقل المرفقات إلى مصفوفة تلقائياً
    protected $casts = [
        'attachments' => 'array',
        'start_at' => 'datetime',
        'end_at' => 'datetime',
    ];

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function participants()
    {
        return $this->belongsToMany(User::class)->withPivot('status');
    }
    public function attachments(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Attachment::class);
    }
}
