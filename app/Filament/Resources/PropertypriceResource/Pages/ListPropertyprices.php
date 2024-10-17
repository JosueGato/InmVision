<?php

namespace App\Filament\Resources\PropertypriceResource\Pages;

use App\Filament\Resources\PropertypriceResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPropertyprices extends ListRecords
{
    protected static string $resource = PropertypriceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
