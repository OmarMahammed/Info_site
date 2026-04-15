<?php

namespace App\Filament\Resources\PrivacyPolicies\Pages;

use App\Filament\Resources\PrivacyPolicies\PrivacyPolicyResource;
use App\Models\PrivacyPolicy;
use Filament\Resources\Pages\ListRecords;

class ListPrivacyPolicies extends ListRecords
{
    protected static string $resource = PrivacyPolicyResource::class;

    public function mount(): void
    {
        parent::mount();

        $record = PrivacyPolicy::ensureExists();

        $this->redirect(PrivacyPolicyResource::getUrl('edit', ['record' => $record]));
    }

    protected function getHeaderActions(): array
    {
        return [];
    }
}
