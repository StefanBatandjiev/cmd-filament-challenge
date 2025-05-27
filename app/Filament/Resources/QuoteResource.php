<?php

namespace App\Filament\Resources;

use App\Enums\QuoteStatus;
use App\Enums\ServiceType;
use App\Filament\Resources\QuoteResource\Pages;
use App\Filament\Resources\QuoteResource\RelationManagers;
use App\Models\Quote;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class QuoteResource extends Resource
{
    protected static ?string $model = Quote::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('phone')
                    ->searchable(),
                Tables\Columns\TextColumn::make('address')
                    ->searchable(),
                Tables\Columns\TextColumn::make('service')
                    ->badge(),
                Tables\Columns\TextColumn::make('booked_at')
                    ->dateTime(),
                Tables\Columns\TextColumn::make('duration')
                    ->numeric(),
                Tables\Columns\TextColumn::make('status')
                    ->badge(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->toggleable(true, true)

            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options(QuoteStatus::class),
                Tables\Filters\SelectFilter::make('service')
                    ->options(ServiceType::class),
                Filter::make('created_at')
                    ->form([
                        Forms\Components\DatePicker::make('created_at')
                            ->label('Created Date')
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_at'],
                                fn(Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                            );
                    })
                    ->indicateUsing(function (array $data): ?string {
                        if (! $data['created_at']) {
                            return null;
                        }

                        return 'Created at ' . Carbon::parse($data['created_at'])->toFormattedDateString();
                    }),
                Filter::make('booked_at')
                    ->form([
                        Forms\Components\DatePicker::make('booked_at')
                            ->label('Booked Date')
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['booked_at'],
                                fn(Builder $query, $date): Builder => $query->whereDate('booked_at', '<=', $date),
                            );
                    })
                    ->indicateUsing(function (array $data): ?string {
                        if (! $data['booked_at']) {
                            return null;
                        }

                        return 'Booked at ' . Carbon::parse($data['booked_at'])->toFormattedDateString();
                    }),
            ])
            ->defaultSort('booked_at', 'desc')
            ->actions([
                Tables\Actions\EditAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListQuotes::route('/'),
            'create' => Pages\CreateQuote::route('/create'),
            'edit' => Pages\EditQuote::route('/{record}/edit'),
        ];
    }
}
