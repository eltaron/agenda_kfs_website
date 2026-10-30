<?php

namespace App\Filament\Resources\MeetingResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use App\Models\User;

class ParticipantsRelationManager extends RelationManager
{
    protected static string $relationship = 'participants';

    // تغيير عنوان القسم
    protected static ?string $title = 'قائمة الحضور والمراسلة الفردية';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('اسم المشارك')
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('phone')
                    ->label('رقم الهاتف')
                    ->icon('heroicon-m-phone')
                    ->color('success'),

                Tables\Columns\TextColumn::make('category.name')
                    ->label('الوظيفة/الفئة')
                    ->badge(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                // إمكانية إضافة مشارك جديد من هنا مباشرة
                Tables\Actions\AttachAction::make()
                    ->label('إضافة مشارك')
                    ->preloadRecordSelect(),
            ])
            ->actions([
                // --- زر الواتساب اليدوي لكل شخص ---
                Tables\Actions\Action::make('whatsapp_manual')
                    ->label('مراسلة واتساب')
                    ->icon('heroicon-o-chat-bubble-left-right')
                    ->color('success')
                    ->url(function (User $record, RelationManager $livewire) {
                        // جلب بيانات الاجتماع الحالي
                        $meeting = $livewire->getOwnerRecord();

                        if (!$record->phone) return null;

                        $phone = preg_replace('/[^0-9]/', '', $record->phone);
                        if (str_starts_with($phone, '01')) {
                            $phone = '2' . $phone;
                        }

                        // نص الرسالة المجهزة بالموعد
                        $msg = "السلام عليكم  {$record->name}، نذكرك بموعد الاجتماع: {$meeting->title} الساعة {$meeting->start_at->format('h:i A')}";

                        return "https://wa.me/{$phone}?text=" . urlencode($msg);
                    })
                    ->openUrlInNewTab(),
                // -------------------------------------

                Tables\Actions\DetachAction::make()->label('إزالة'),
            ])
            ->bulkActions([
                Tables\Actions\DetachBulkAction::make(),
            ]);
    }
}
