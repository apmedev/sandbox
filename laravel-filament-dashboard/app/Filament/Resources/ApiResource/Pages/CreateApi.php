<?php

namespace App\Filament\Resources\ApiResource\Pages;

use App\Filament\Resources\ApiResource;
use Filament\Forms\Components\Checkbox;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;
use Filament\Forms\Components\Wizard\Step;
use Filament\Forms\Components\TextInput;
class CreateApi extends CreateRecord
{
    use CreateRecord\Concerns\HasWizard;
    protected static string $resource = ApiResource::class;

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
                    TextInput::make('key')
                        ->label('Key')
                        ->placeholder('Enter the key')
                        ->required(),
                ]),
            Step::make('Details')
                ->description('Details.')
                ->schema([
                    TextInput::make('base_url')
                        ->label('Base Url')
                        ->placeholder('Enter the base URL')
                        ->required(),
                    TextInput::make('action_url')
                        ->label('Action Url')
                        ->placeholder('Enter the targeted endpoint')
                        ->required(),
                    Checkbox::make('custom_handling')
                        ->label('Has custom data parsing'),
                ]),
        ];
    }
}
