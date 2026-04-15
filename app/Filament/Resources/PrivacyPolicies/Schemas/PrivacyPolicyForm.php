<?php

namespace App\Filament\Resources\PrivacyPolicies\Schemas;

use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;

class PrivacyPolicyForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(__('Privacy Policy'))
                    ->description(__('Manage the legal page shown at /privacy. Arabic and English are stored separately.'))
                    ->schema([
                        Tabs::make(__('Languages'))
                            ->tabs([
                                Tab::make(__('Arabic'))
                                    ->schema([
                                        TextInput::make('title_ar')
                                            ->label(__('Title (Arabic)'))
                                            ->required()
                                            ->maxLength(255)
                                            ->columnSpanFull(),
                                    ]),
                                Tab::make(__('English'))
                                    ->schema([
                                        TextInput::make('title_en')
                                            ->label(__('Title (English)'))
                                            ->required()
                                            ->maxLength(255)
                                            ->columnSpanFull(),
                                    ]),
                            ])
                            ->columnSpanFull(),
                        Repeater::make('sections')
                            ->label(__('Policy sections'))
                            ->required()
                            ->defaultItems(1)
                            ->reorderable(true)
                            ->collapsible()
                            ->itemLabel(fn (array $state): string => $state['title_ar'] ?? __('Section'))
                            ->schema([
                                Tabs::make(__('Section languages'))
                                    ->tabs([
                                        Tab::make(__('Arabic'))
                                            ->schema([
                                                TextInput::make('title_ar')
                                                    ->label(__('Section title (Arabic)'))
                                                    ->required()
                                                    ->maxLength(255),
                                                Textarea::make('desc_ar')
                                                    ->label(__('Section description (Arabic)'))
                                                    ->required()
                                                    ->rows(4),
                                            ]),
                                        Tab::make(__('English'))
                                            ->schema([
                                                TextInput::make('title_en')
                                                    ->label(__('Section title (English)'))
                                                    ->required()
                                                    ->maxLength(255),
                                                Textarea::make('desc_en')
                                                    ->label(__('Section description (English)'))
                                                    ->required()
                                                    ->rows(4),
                                            ]),
                                    ]),
                            ])
                            ->columnSpanFull(),
                        Toggle::make('is_active')
                            ->label(__('Visible on website'))
                            ->helperText(__('When disabled, visitors see the default static privacy page instead.'))
                            ->default(true)
                            ->inline(false),
                    ]),
            ]);
    }
}
