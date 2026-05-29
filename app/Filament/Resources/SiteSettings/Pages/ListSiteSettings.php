<?php

namespace App\Filament\Resources\SiteSettings\Pages;

use App\Filament\Resources\SiteSettings\SiteSettingResource;
use App\Models\SiteSetting;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListSiteSettings extends ListRecords
{
    protected static string $resource = SiteSettingResource::class;

    public function mount(): void
    {
        parent::mount();

        $record = SiteSetting::query()->first();
        if ($record !== null) {
            $this->redirect(SiteSettingResource::getUrl('edit', ['record' => $record]));
        }
    }

    protected function getHeaderActions(): array
    {
        return SiteSetting::query()->exists()
            ? []
            : [
                CreateAction::make(),
            ];
    }
}
