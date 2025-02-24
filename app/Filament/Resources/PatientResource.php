<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Patient;
use Filament\Forms\Form;
use App\Models\Complaint;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use App\Filament\Resources\PatientResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\PatientResource\RelationManagers;

class PatientResource extends Resource
{
    protected static ?string $model = Patient::class;
    protected static bool $canCreateAnother = false;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $recordTitleAttribute = 'name';


    public static function getGlobalSearchResultTitle(Model $record): string
    {
        return $record->name . ' :: ' . $record->op_number;
    }



    public static function getGloballySearchableAttributes(): array
    {
        return ['name', 'op_number', 'mobile', 'occupation', 'complaints.case_detail', 'complaints.medication', 'complaints.lab_reports', 'complaints.case_no'];
    }



    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Personal Information')
                    ->schema([
                        TextInput::make('op_number')
                            ->default(fn(Patient $patient) => $patient->newOpNumber())
                            ->readOnly(),
                        TextInput::make('name')
                            ->required(),

                        TextInput::make('mobile')
                            ->required()
                            ->mask(9999999999)
                            ->minValue(6000000000)
                            ->maxValue(9999999999)
                            ->numeric(),
                    ])
                    ->columns(3),
                Section::make('Other Informations')
                    ->schema([
                        TextInput::make('address'),
                        TextInput::make('gender'),
                        DatePicker::make('dob')
                            ->native(false),
                        TextInput::make('occupation'),
                        FileUpload::make('image')
                            ->image()
                            ->imageEditor()
                            ->columnSpanFull(),
                    ])
                    ->columns(4)
                    ->collapsed(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('op_number')
                    ->searchable(),
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('mobile')
                    ->searchable(),
                Tables\Columns\TextColumn::make('dob')
                    ->date()
                    ->since(),
                Tables\Columns\TextColumn::make('occupation')
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->label('Complaint'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
            RelationManagers\ComplaintsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPatients::route('/'),
            'create' => Pages\CreatePatient::route('/create'),
            'edit' => Pages\EditPatient::route('/{record}/edit'),
        ];
    }
}
