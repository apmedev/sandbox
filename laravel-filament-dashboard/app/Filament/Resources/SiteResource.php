<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SiteResource\Pages;
use App\Models\Site;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;

class SiteResource extends Resource
{
    protected static ?string $model = Site::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                [
                    TextInput::make('title')
                        ->label('Title')
                        ->placeholder('Enter the title')
                        ->required(),

                    TextInput::make('url')
                        ->label('URL')
                        ->placeholder('Enter the URL')
                        ->required(),

                    TextInput::make('keywords')
                        ->label('Keywords')
                        ->placeholder('Enter the keywords')
                        ->required(),

                    TextInput::make('topics')
                        ->label('Topics')
                        ->placeholder('Enter the topics')
                        ->required(),

                    Select::make('crawl_interval')
                        ->label('Crawl Interval')
                        ->placeholder('Select the crawl interval')
                        ->options([
                            'daily' => 'Daily',
                            'weekly' => 'Weekly',
                            'monthly' => 'Monthly',
                        ])
                        ->required(),
                ]
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                ->label('Title')
                ->sortable()
                ->searchable(),

                Tables\Columns\TextColumn::make('url')
                    ->label('URL')
                    ->sortable(),

                Tables\Columns\TextColumn::make('keywords')
                    ->label('Keywords')
                    ->sortable(),

                Tables\Columns\TextColumn::make('last_scraped')
                    ->label('Last Scraped')
                    ->sortable(),

                Tables\Columns\TextColumn::make('topic')
                    ->label('Topic')
                    ->sortable(),

                Tables\Columns\TextColumn::make('crawl_interval')
                    ->label('Crawl Interval')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListSites::route('/'),
            'create' => Pages\CreateSite::route('/create'),
            'edit' => Pages\EditSite::route('/{record}/edit'),
        ];
    }
}
