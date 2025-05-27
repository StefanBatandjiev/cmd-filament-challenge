<?php

namespace App\Filament\Resources\QuoteResource\Pages;

use App\Filament\Resources\QuoteResource;
use Filament\Actions;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Pages\ViewRecord;
use function PHPUnit\Framework\isNull;

class ViewQuote extends ViewRecord
{
    protected static string $resource = QuoteResource::class;

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Section::make()
                    ->schema([
                        TextEntry::make('name'),
                        TextEntry::make('email'),
                        TextEntry::make('phone'),
                        TextEntry::make('address'),
                        TextEntry::make('service')
                            ->badge()
                            ->formatStateUsing(fn($state) => $state->getLabel() . ' - ' . '$' . $state->getPrice() . '/hr'),
                        TextEntry::make('booked_at')
                            ->dateTime(),
                        TextEntry::make('duration')
                            ->numeric(),
                        TextEntry::make('price')
                            ->numeric()
                            ->default(function () {
                                $price = $this->record->price;
                                $duration = $this->record->duration;

                                return $price
                                    ? '$' . $price
                                    : '$' . number_format($this->record->service->getPrice() * $duration, 2);
                            }),
                        TextEntry::make('status')->badge(),
                        TextEntry::make('notes')
                    ])->columns(2)
            ]);
    }
}
