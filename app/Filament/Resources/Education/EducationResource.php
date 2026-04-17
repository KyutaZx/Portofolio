<?php

namespace App\Filament\Resources\Education;

use App\Filament\Resources\Education\Pages;
use App\Models\Education;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Filament\Schemas\Schema;

class EducationResource extends Resource
{
    protected static ?string $model = Education::class;

    // Icon buku/universitas
    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-academic-cap';

    // Label menu
    protected static ?string $navigationLabel = 'Pendidikan';
    protected static ?string $modelLabel = 'Pendidikan';
    protected static ?string $pluralModelLabel = 'Daftar Pendidikan';

    // Urutan menu
    protected static ?int $navigationSort = 5;

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            \Filament\Schemas\Components\Section::make('Riwayat Pendidikan')
                ->description('Tambahkan informasi pendidikan kamu (universitas, sekolah, dll.)')
                ->schema([
                    \Filament\Forms\Components\TextInput::make('institution')
                        ->label('Nama Institusi')
                        ->placeholder('Contoh: Universitas Bina Nusantara (BINUS)')
                        ->required()
                        ->maxLength(255),

                    \Filament\Forms\Components\TextInput::make('degree')
                        ->label('Jenjang / Gelar')
                        ->placeholder('Contoh: S1, D3, SMA/SMK')
                        ->required()
                        ->maxLength(255),

                    \Filament\Forms\Components\TextInput::make('major')
                        ->label('Jurusan / Program Studi')
                        ->placeholder('Contoh: Teknik Informatika, Sistem Informasi')
                        ->nullable()
                        ->maxLength(255),

                    \Filament\Forms\Components\DatePicker::make('start_date')
                        ->label('Tahun Masuk')
                        ->required()
                        ->displayFormat('Y')
                        ->format('Y-m-d'),

                    \Filament\Forms\Components\DatePicker::make('end_date')
                        ->label('Tahun Lulus')
                        ->nullable()
                        ->displayFormat('Y')
                        ->format('Y-m-d')
                        ->helperText('Kosongkan jika masih aktif kuliah/sekolah.'),
                ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                \Filament\Tables\Columns\TextColumn::make('institution')
                    ->label('Institusi')
                    ->searchable()
                    ->weight('bold'),

                \Filament\Tables\Columns\TextColumn::make('degree')
                    ->label('Jenjang')
                    ->badge()
                    ->color('primary'),

                \Filament\Tables\Columns\TextColumn::make('major')
                    ->label('Jurusan')
                    ->searchable()
                    ->placeholder('—'),

                \Filament\Tables\Columns\TextColumn::make('start_date')
                    ->label('Masuk')
                    ->date('Y')
                    ->sortable(),

                \Filament\Tables\Columns\TextColumn::make('end_date')
                    ->label('Lulus')
                    ->date('Y')
                    ->placeholder('Sekarang')
                    ->sortable(),
            ])
            ->defaultSort('start_date', 'desc')
            ->actions([
                \Filament\Actions\EditAction::make(),
                \Filament\Actions\DeleteAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListEducation::route('/'),
            'create' => Pages\CreateEducation::route('/create'),
            'edit'   => Pages\EditEducation::route('/{record}/edit'),
        ];
    }
}
