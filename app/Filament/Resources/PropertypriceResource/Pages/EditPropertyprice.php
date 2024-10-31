<?php

namespace App\Filament\Resources\PropertypriceResource\Pages;

use App\Filament\Resources\PropertypriceResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPropertyprice extends EditRecord
{
    protected static string $resource = PropertypriceResource::class;
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
