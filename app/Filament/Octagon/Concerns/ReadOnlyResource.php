<?php

namespace App\Filament\Octagon\Concerns;

use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Model;

/**
 * Resource للقراءة فقط: يسمح بالعرض فقط ويمنع الإضافة والتعديل والحذف نهائياً.
 * صلاحية الدخول نفسها محكومة على مستوى اللوحة (User::canAccessPanel).
 */
abstract class ReadOnlyResource extends Resource
{
    public static function can(string $action, ?Model $record = null): bool
    {
        return in_array($action, ['viewAny', 'view'], true);
    }
}
