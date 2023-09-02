<?php

namespace App\Filament\Resources\SiteResource\Pages;

use App\Filament\Resources\SiteResource;
use Filament\Forms\Components\Select;
use Filament\Resources\Pages\CreateRecord;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Wizard\Step;
class CreateSite extends CreateRecord
{
    use CreateRecord\Concerns\HasWizard;

    protected static string $resource = SiteResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getSteps(): array
    {
        return [
            Step::make('Info')
                ->description('Basic resource info')
                ->schema([
                    TextInput::make('title')
                        ->label('Title')
                        ->placeholder('Enter the title')
                        ->required(),
                    TextInput::make('url')
                        ->label('URL')
                        ->placeholder('Enter the URL')
                        ->required(),
                ]),
            Step::make('Keywords')
                ->description('Keywords to be targeted.')
                ->schema([
                    TextInput::make('keywords')
                        ->label('Keywords')
                        ->placeholder('Enter the keywords')
                        ->required(),
                    TextInput::make('topic')
                        ->label('Topics')
                        ->placeholder('Enter the keywords')
                        ->required(),
                ]),
            Step::make('Crawl Interval')
                ->description('Howe often to check the site.')
                ->schema([
                    Select::make('crawl_interval')
                        ->label('Crawl Interval')
                        ->placeholder('Select the crawl interval')
                        ->options([
                            'daily' => 'Daily',
                            'weekly' => 'Weekly',
                            'monthly' => 'Monthly',
                        ])
                        ->required(),
                ]),
        ];
    }
}
