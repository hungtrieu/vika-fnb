<?php

namespace App\Filament\Resources\OrderResource\Pages;

use App\Filament\Resources\OrderResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

class EditOrder extends EditRecord
{
    protected static string $resource = OrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        $refined_data = $this->prepareOrderData($record, $data);

        $record->update($refined_data);

        return $record;
    }

    protected function prepareOrderData(Model $record, array $data) : array {
        $refined_data = $data;
        // calculate order amount
        $order_items = $record->items()->get();

        $order_amount = 0;

        if($order_items) {
            foreach($order_items as $item) {
                $order_amount += $item->amount;
            }
        }

        $refined_data['amount'] = $order_amount;

        return $refined_data;
    }
}
