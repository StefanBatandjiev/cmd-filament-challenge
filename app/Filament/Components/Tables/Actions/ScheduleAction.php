<?php

namespace App\Filament\Components\Tables\Actions;

use App\Enums\QuoteStatus;
use Filament\Tables\Actions\Action;

class ScheduleAction extends Action
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->label('Schedule');

        $this->requiresConfirmation();
        $this->color('info');
        $this->button();

        $this->authorize('schedule');

        $this->action(function ($record, array $data) {
            $record->update([
                'status' => QuoteStatus::SCHEDULED
            ]);
        });
    }
}
