<?php

namespace App\Filament\Resources\PrivacyPolicies;

use App\Filament\Resources\PrivacyPolicies\Pages\EditPrivacyPolicy;
use App\Filament\Resources\PrivacyPolicies\Pages\ListPrivacyPolicies;
use App\Filament\Resources\PrivacyPolicies\Schemas\PrivacyPolicyForm;
use App\Filament\Resources\PrivacyPolicies\Tables\PrivacyPoliciesTable;
use App\Models\PrivacyPolicy;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class PrivacyPolicyResource extends Resource
{
    protected static ?string $model = PrivacyPolicy::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedShieldCheck;

    protected static ?int $navigationSort = 40;

    public static function form(Schema $schema): Schema
    {
        return PrivacyPolicyForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PrivacyPoliciesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPrivacyPolicies::route('/'),
            'edit' => EditPrivacyPolicy::route('/{record}/edit'),
        ];
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function canDelete(Model $record): bool
    {
        return false;
    }

    public static function canDeleteAny(): bool
    {
        return false;
    }

    public static function getNavigationLabel(): string
    {
        return __('Privacy Policy');
    }

    public static function getModelLabel(): string
    {
        return __('Privacy Policy');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Privacy Policy');
    }
}
