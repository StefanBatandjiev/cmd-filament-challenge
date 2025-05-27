<?php

namespace App\Filament\Components\Tables\Actions;

use App\Enums\QuoteStatus;
use App\Notifications\QuoteRejectedNotification;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Actions\Action;
use Illuminate\Support\Facades\Notification;

class RejectAction extends Action
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->label('Reject');

        $this->form([
            Textarea::make('reason')
        ]);

        $this->requiresConfirmation();
        $this->color('danger');
        $this->button();

        $this->authorize('reject');

        $this->action(function ($record, array $data) {

            $record->update([
                'status' => QuoteStatus::REJECTED
            ]);

            Notification::route('mail', $record->email)
                ->notify(new QuoteRejectedNotification($record, $data['reason']));
        });
    }
}
