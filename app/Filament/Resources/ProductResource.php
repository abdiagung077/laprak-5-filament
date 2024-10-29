<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Models\Product;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ToggleColumn;
use Illuminate\Support\Facades\Storage;


class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('name')
                ->required(),
            Forms\Components\TextInput::make('quantity')
                ->required(),
            Forms\Components\Toggle::make('is_available')
                ->required(),
            Forms\Components\FileUpload::make('image')
                ->nullable(),
            Forms\Components\FileUpload::make('file')
                ->nullable(),
            Forms\Components\Select::make('category_id')
                ->relationship('category', 'name')
                ->required(),
        ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->label('Product Name'),
                Tables\Columns\TextColumn::make('quantity')->label('Quantity'),
                Tables\Columns\ToggleColumn::make('is_available')->label('Available')
                    ->onColor('success')->offColor('danger'),
                Tables\Columns\TextColumn::make('category.name')->label('Category'),
                Tables\Columns\TextColumn::make('image') // Menampilkan gambar
                    ->label('Image')
                    ->formatStateUsing(fn($state) => $state ? '<img src="' . Storage::url($state) . '" alt="Image" style="width: 50px; height: auto;">' : 'No image')
                    ->html(), // Agar bisa menampilkan HTML
                Tables\Columns\TextColumn::make('file') // Menampilkan file
                    ->label('File')
                    ->formatStateUsing(fn($state) => $state ? '<a href="' . Storage::url($state) . '" target="_blank">Download</a>' : 'No file')
                    ->html(), // Agar bisa menampilkan HTML
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
