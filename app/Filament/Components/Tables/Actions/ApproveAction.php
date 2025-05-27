<?php

namespace App\Filament\Components\Tables\Actions;

use App\Enums\QuoteStatus;
use App\Notifications\QuoteApprovedNotification;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Actions\Action;
use Illuminate\Support\Facades\Notification;

class ApproveAction extends Action
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->label('Approve');

        $this->form([
            TextInput::make('price')
                ->numeric()
                ->label('Override Price (optional)')
                ->default(fn($record) => number_format($record->service->getPrice() * $record->duration, 2)),
        ]);

        $this->requiresConfirmation();
        $this->color('success');
        $this->button();

        $this->authorize('approve');

        $this->action(function ($record, array $data) {
            $record->price = $data['price'] ?? ($record->getServicePrice() * $record->duration);
            $record->status = QuoteStatus::APPROVED;
            $record->save();

            Notification::route('mail', $record->email)
                ->notify(new QuoteApprovedNotification($record));
        });
    }
}
