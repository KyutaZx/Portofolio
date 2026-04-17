<?php

namespace App\Filament\Resources\Identities;

use App\Filament\Resources\Identities\Pages;
use App\Models\Identity;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Filament\Schemas\Schema;
use Filament\Forms;
use Filament\Tables;
use Filament\Actions;

class IdentityResource extends Resource
{
    protected static ?string $model = Identity::class;

    // KUNCI PERBAIKAN: Tipe data harus sesuai dengan class Resource bawaan Filament 5.5
    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-user-circle';
    
    protected static ?int $navigationSort = 1;

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            
            \Filament\Schemas\Components\Section::make('Profil Utama')
                ->description('Informasi dasar identitas profesional kamu.')
                ->schema([
                    \Filament\Forms\Components\TextInput::make('name')
                        ->label('Nama Lengkap')
                        ->required()
                        ->maxLength(255),

                    \Filament\Forms\Components\TextInput::make('title')
                        ->label('Jabatan / Profesi')
                        ->required() 
                        ->maxLength(255),

                    \Filament\Forms\Components\FileUpload::make('avatar')
                        ->label('Foto Profil')
                        ->image()
                        ->disk('public')
                        ->directory('identities')
                        ->columnSpanFull()
                        ->required(),

                    \Filament\Forms\Components\Textarea::make('bio')
                        ->label('Bio Singkat')
                        ->rows(4)
                        ->columnSpanFull(),
                ])->columns(2),

            \Filament\Schemas\Components\Section::make('Kontak & Jejaring')
                ->schema([
                    \Filament\Forms\Components\TextInput::make('email')
                        ->email()
                        ->maxLength(255),

                    \Filament\Forms\Components\TextInput::make('github_link')
                        ->label('URL GitHub')
                        ->url()
                        ->maxLength(255),

                    \Filament\Forms\Components\TextInput::make('linkedin_link')
                        ->label('URL LinkedIn')
                        ->url()
                        ->maxLength(255),
                ])->columns(3),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                \Filament\Tables\Columns\ImageColumn::make('avatar')
                    ->label('Foto')
                    ->circular(),

                \Filament\Tables\Columns\TextColumn::make('name')
                    ->label('Nama')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                \Filament\Tables\Columns\TextColumn::make('title')
                    ->label('Profesi')
                    ->badge()
                    ->color('info'),

                \Filament\Tables\Columns\TextColumn::make('email')
                    ->label('Kontak')
                    ->icon('heroicon-m-envelope'),
            ])
            ->filters([])
            ->actions([
                \Filament\Actions\EditAction::make(),
                \Filament\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                \Filament\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListIdentities::route('/'),
            'create' => Pages\CreateIdentity::route('/create'),
            'edit' => Pages\EditIdentity::route('/{record}/edit'),
        ];
    }
}