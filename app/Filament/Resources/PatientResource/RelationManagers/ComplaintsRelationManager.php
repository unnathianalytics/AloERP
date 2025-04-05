<?php

namespace App\Filament\Resources\PatientResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use App\Models\Complaint;
use Filament\Tables\Table;
use Illuminate\Support\Carbon;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\RelationManagers\RelationManager;

class ComplaintsRelationManager extends RelationManager
{
    protected static string $relationship = 'complaints';
    protected static bool $canCreateAnother = false;


    public function form(Form $form): Form
    {
        $now = Carbon::now();
        $minDate = $now->copy()->subDays(7);
        return $form->schema([
            TextInput::make('case_no')
                ->default(fn () => Complaint::newCaseNumber())
                ->readOnly()
                ->required(),
            DatePicker::make('case_date')
                ->native(false)
                ->default($now)
                ->minDate($minDate)
                ->maxDate($now)
                ->required(),
            Textarea::make('case_detail')
                ->required()
                ->rows(3),
            Textarea::make('medication')
                ->rows(3),
            Textarea::make('lab_reports')
                ->rows(3),
            FileUpload::make('uploads')
                ->multiple()
                ->maxFiles(5)
                ->downloadable(),
        ]);
    }
    

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('case')
            ->columns([
                TextColumn::make('case_no')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('case_date')
                    ->date()
                    ->sortable(),
                TextColumn::make('case_detail')
                    ->searchable()
                    ->limit(50),
                TextColumn::make('medication')
                    ->searchable()
                    ->limit(50),

            ])
            ->defaultSort('case_date', 'desc')
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->createAnother(false),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                //Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    //Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
