<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ApiResource\Pages;
use App\Models\Api;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;

class ApiResource extends Resource
{
    protected static ?string $model = Api::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';
    
    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                ->label('Title')
                ->sortable()
                ->searchable(),

                Tables\Columns\TextColumn::make('key')
                    ->label('KEY')
                    ->sortable(),

                Tables\Columns\TextColumn::make('base_url')
                    ->label('Base')
                    ->sortable(),
    
                Tables\Columns\TextColumn::make('action_url')
                    ->label('Action')
                    ->sortable(),
    
                Tables\Columns\CheckboxColumn::make('custom_handling')
                    ->label('CH'),
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListApis::route('/'),
            'create' => Pages\CreateApi::route('/create'),
            'edit' => Pages\EditApi::route('/{record}/edit'),
        ];
    }    
}
