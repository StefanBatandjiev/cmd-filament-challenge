<?php

namespace App\Filament\Components\Tables\Actions;

use App\Enums\QuoteStatus;
use Filament\Tables\Actions\Action;

class InvoiceAction extends Action
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->label('Invoice');

        $this->requiresConfirmation();
        $this->color('primary');
        $this->button();

        $this->authorize('invoice');

        $this->action(function ($record, array $data) {
            $record->update([
                'status' => QuoteStatus::INVOICED
            ]);
        });
    }
}
