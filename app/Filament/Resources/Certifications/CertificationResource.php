<?php

namespace App\Filament\Resources\Certifications; // Sesuaikan dengan folder Certifications

use App\Filament\Resources\Certifications\Pages; // Sesuaikan dengan folder Certifications
use App\Models\Certification;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Filament\Schemas\Schema;

class CertificationResource extends Resource
{
    protected static ?string $model = Certification::class;

    // Logo lencana untuk sertifikat
    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-check-badge';
    
    // Urutan menu ke-6
    protected static ?int $navigationSort = 6;

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            \Filament\Schemas\Components\Section::make('Detail Sertifikasi')
                ->schema([
                    \Filament\Forms\Components\TextInput::make('name')
                        ->label('Nama Sertifikasi')
                        ->required()
                        ->maxLength(255),
                    \Filament\Forms\Components\TextInput::make('issuer')
                        ->label('Penerbit (Issuer)')
                        ->placeholder('Contoh: Google, Coursera, Dicoding')
                        ->required()
                        ->maxLength(255),
                    \Filament\Forms\Components\DatePicker::make('issued_at')
                        ->label('Tanggal Terbit')
                        ->required(),
                    \Filament\Forms\Components\TextInput::make('credential_url')
                        ->label('URL Kredensial / Link Sertifikat')
                        ->url() 
                        ->maxLength(255)
                        ->columnSpanFull(),
                ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                \Filament\Tables\Columns\TextColumn::make('name')
                    ->label('Nama Sertifikat')
                    ->searchable()
                    ->weight('bold'),
                \Filament\Tables\Columns\TextColumn::make('issuer')
                    ->label('Penerbit')
                    ->searchable(),
                \Filament\Tables\Columns\TextColumn::make('issued_at')
                    ->label('Tanggal Terbit')
                    ->date()
                    ->sortable(),
            ])
            ->actions([
                \Filament\Actions\EditAction::make(),
                \Filament\Actions\DeleteAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCertifications::route('/'),
            'create' => Pages\CreateCertification::route('/create'),
            'edit' => Pages\EditCertification::route('/{record}/edit'),
        ];
    }
}