<?php

namespace App\Filament\Resources\PrivacyPolicies\Tables;

use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PrivacyPoliciesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title_en')
                    ->label(__('Title (English)'))
                    ->searchable()
                    ->limit(40),
                TextColumn::make('title_ar')
                    ->label(__('Title (Arabic)'))
                    ->searchable()
                    ->limit(40),
                IconColumn::make('is_active')
                    ->label(__('Visible'))
                    ->boolean(),
                TextColumn::make('updated_at')
                    ->label(__('Last updated'))
                    ->dateTime()
                    ->sortable(),
            ])
            ->actions([
                EditAction::make(),
            ])
            ->bulkActions([]);
    }
}
