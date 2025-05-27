<?php

namespace App\Livewire;


use App\Enums\QuoteStatus;
use App\Models\Quote;
use App\Enums\ServiceType;
use App\Notifications\NewQuoteNotification;
use App\Notifications\QuoteReceivedNotification;
use Illuminate\Support\Facades\Notification;
use Livewire\Component;

class QuoteRequestForm extends Component
{
    public string $name = '';
    public string $email = '';
    public string $phone = '';
    public string $address = '';
    public string $service = '';
    public string $booked_at = '';

    public int $duration = 1;
    public string $notes = '';

    public function submit(): void
    {
        $this->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'phone' => 'required|string',
            'address' => 'required|string',
            'service' => 'required',
            'booked_at' => 'required|date',
            'duration' => 'required|integer|min:1',
            'notes' => 'nullable|string',
        ]);

        $quote = Quote::create([
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'address' => $this->address,
            'service' => $this->service,
            'booked_at' => $this->booked_at,
            'duration' => $this->duration,
            'notes' => $this->notes,
            'status' => QuoteStatus::PENDING,
        ]);

        Notification::route('mail', $this->email)
            ->notify(new QuoteReceivedNotification($quote));

        Notification::route('mail', config('mail.from.address'))
            ->notify(new NewQuoteNotification($quote));

        session()->flash('success', 'Your quote request has been submitted!');

        $this->reset();
    }

    public function render()
    {
        return view('livewire.quote-request-form', [
            'services' => ServiceType::cases(),
        ]);
    }
}
