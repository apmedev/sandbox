<?php

namespace App\Filament\Resources\ApiResource\Pages;

use App\Filament\Resources\ApiResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Tables\Columns\Text;
use Filament\Resources\RelationManagers\Concerns\CanDeleteRecords;
use Filament\Tables\Columns\CheckboxColumn;

class ListApis extends ListRecords
{
    use CanDeleteRecords;
    protected static string $resource = ApiResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function columns()
    {
        return [
            Text::make('title')
                ->label('Title')
                ->sortable()
                ->searchable(),

            Text::make('key')
                ->label('KEY')
                ->sortable(),

            Text::make('base_url')
                ->label('KEY')
                ->sortable(),

            Text::make('action_url')
                ->label('KEY')
                ->sortable(),

            CheckboxColumn::make('custom_handling'),

        ];
    }
}
