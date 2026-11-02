<?php

namespace App\Filament\Octagon\Concerns;

use App\Models\Meeting;
use Illuminate\Database\Eloquent\Builder;

/**
 * حالة الاجتماع محسوبة من التوقيت: قادم / جارٍ / مؤرشف (منتهي).
 */
class MeetingStatus
{
    public const UPCOMING = 'upcoming';
    public const ONGOING = 'ongoing';
    public const ARCHIVED = 'archived';

    public static function labels(): array
    {
        return [
            self::UPCOMING => 'قادم',
            self::ONGOING => 'جارٍ الآن',
            self::ARCHIVED => 'مؤرشف (منتهي)',
        ];
    }

    public static function colors(): array
    {
        return [
            self::UPCOMING => 'info',
            self::ONGOING => 'success',
            self::ARCHIVED => 'gray',
        ];
    }

    public static function of(Meeting $meeting): string
    {
        $now = now();

        if ($meeting->end_at && $meeting->end_at->lt($now)) {
            return self::ARCHIVED;
        }

        if ($meeting->start_at && $meeting->start_at->lte($now)) {
            return self::ONGOING;
        }

        return self::UPCOMING;
    }

    public static function scope(Builder $query, ?string $status): Builder
    {
        $now = now();

        return match ($status) {
            self::ARCHIVED => $query->where('end_at', '<', $now),
            self::ONGOING => $query->where('start_at', '<=', $now)->where('end_at', '>=', $now),
            self::UPCOMING => $query->where('start_at', '>', $now),
            default => $query,
        };
    }

    public static function participantStatusLabels(): array
    {
        return [
            'pending' => 'في الانتظار',
            'attending' => 'مؤكد الحضور',
            'declined' => 'معتذر',
        ];
    }

    public static function participantStatusColors(): array
    {
        return [
            'pending' => 'warning',
            'attending' => 'success',
            'declined' => 'danger',
        ];
    }
}
