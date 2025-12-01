<?php

namespace App\Filament\Resources\PedidoItemResource\Pages;

use App\Filament\Resources\PedidoItemResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPedidoItem extends EditRecord
{
    protected static string $resource = PedidoItemResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
