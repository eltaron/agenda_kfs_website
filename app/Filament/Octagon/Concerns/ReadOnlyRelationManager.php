<?php

namespace App\Filament\Octagon\Concerns;

use Filament\Resources\RelationManagers\RelationManager;
use Illuminate\Database\Eloquent\Model;

/**
 * Relation Manager للقراءة فقط.
 */
abstract class ReadOnlyRelationManager extends RelationManager
{
    public function isReadOnly(): bool
    {
        return true;
    }

    public static function canViewForRecord(Model $ownerRecord, string $pageClass): bool
    {
        return true;
    }

    protected function can(string $action, ?Model $record = null): bool
    {
        return in_array($action, ['viewAny', 'view'], true);
    }
}
