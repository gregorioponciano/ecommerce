<?php

namespace App\Filament\Resources\PedidoItemResource\Pages;

use App\Filament\Resources\PedidoItemResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPedidoItems extends ListRecords
{
    protected static string $resource = PedidoItemResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
