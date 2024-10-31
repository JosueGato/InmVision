<?php

namespace App\Filament\Resources\PropertypriceResource\Pages;

use App\Filament\Resources\PropertypriceResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePropertyprice extends CreateRecord
{
    protected static string $resource = PropertypriceResource::class;
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
