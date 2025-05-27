<?php

use App\Enums\ServiceType;
use App\Livewire\QuoteRequestForm;
use App\Models\Quote;
use App\Notifications\NewQuoteNotification;
use App\Notifications\QuoteReceivedNotification;
use Illuminate\Notifications\AnonymousNotifiable;
use Illuminate\Support\Facades\Notification;
use function Pest\Livewire\livewire;

it('submits a valid quote request and sends notifications', function () {
    Notification::fake();

    $response = livewire(QuoteRequestForm::class)
        ->set('name', 'Test Quote Request')
        ->set('email', 'test@mail.com')
        ->set('phone', '123456789')
        ->set('address', 'Test Address')
        ->set('service', ServiceType::CLEANING)
        ->set('booked_at', now()->addDays(1)->format('Y-m-d H:i'))
        ->set('duration', 3)
        ->set('notes', 'Test test')
        ->call('submit');

    $this->assertDatabaseHas('quotes', [
        'name' => 'Test Quote Request',
        'email' => 'test@mail.com',
        'status' => 'pending',
    ]);

    $quote = Quote::first();

    Notification::assertSentTo(
        new AnonymousNotifiable,
        QuoteReceivedNotification::class,
        function ($notification) use ($quote) {
            return $notification->quote->id === $quote->id;
        }
    );

    Notification::assertSentTo(
        new AnonymousNotifiable,
        NewQuoteNotification::class,
        function ($notification) use ($quote) {
            return $notification->quote->id === $quote->id;
        }
    );
});
