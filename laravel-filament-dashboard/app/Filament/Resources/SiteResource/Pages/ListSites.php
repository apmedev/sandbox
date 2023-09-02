<?php

namespace App\Filament\Resources\SiteResource\Pages;

use App\Filament\Resources\SiteResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Tables\Columns\Text;
use Filament\Resources\RelationManagers\Concerns\CanDeleteRecords;

class ListSites extends ListRecords
{
    use CanDeleteRecords;

    protected static string $resource = SiteResource::class;

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

            Text::make('url')
                ->label('URL')
                ->sortable(),

            Text::make('keywords')
                ->label('Keywords')
                ->sortable(),

            Text::make('last_scraped')
                ->label('Last Scraped')
                ->sortable(),

            Text::make('topic')
                ->label('Topic')
                ->sortable(),

            Text::make('crawl_interval')
                ->label('Crawl Interval')
                ->sortable(),
        ];
    }
}
