<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TransactionResource\Pages;
use App\Filament\Resources\TransactionResource\RelationManagers;
use App\Models\Transaction;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Actions\DeleteAction as ActionsDeleteAction;
use Filament\Tables\Actions\RestoreAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Filters\TrashedFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Database\Eloquent\Model;

class TransactionResource extends Resource
{
    protected static ?string $model = Transaction::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function canCreate(): bool
    {
        return auth()->user()->isStaff();
    }

    public static function canEdit(Model $record): bool
    {
        return auth()->user()->isStaff();
    }

    public static function canDelete(Model $record): bool
    {
        return auth()->user()->isStaff();
    }

    public static function canAccess(): bool
    {
        return ! auth()->user()->isClient();
    }

    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            Section::make()
                ->schema([
                    Forms\Components\TextInput::make('item_no')
                        ->label('Item No')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('control_no')
                        ->label('Control No')
                        ->required()
                        ->maxLength(255),
                    Select::make('party_represented')
                        ->label('Party Represented')
                        ->required()
                        ->options([
                            'accused' => 'Accused',
                            'respondents' => 'Respondents',
                            'defendants' => 'Defendants',
                            'petitioner' => 'Petitioner',
                            'plaintiff' => 'Plaintiff',
                        ]),
                    Select::make('gender')
                        ->options([
                            'Male' => 'Male',
                            'Female' => 'Female',
                        ])
                        ->required()
                        ->label('Gender'),
                    Forms\Components\TextInput::make('title_of_case')
                        ->required()
                        ->maxLength(255),
                    Select::make('court_body')
                        ->label('Court/Body')
                        ->required()
                        ->options([
                            'RTC 34' => 'RTC 34',
                            'RTC 4' => 'RTC 4',
                            'RTC 3' => 'RTC 3',
                            'MTCC' => 'MTCC',
                            'MCTC-CARMEN' => 'MCTC-CARMEN',
                            'MCTC STO. TOMAS' => 'MCTC STO. TOMAS',
                        ]),
                    Select::make('case_type')
                        ->label('Type of Case')
                        ->required()
                        ->options([
                            'Criminal' => 'Criminal',
                            'Administrative' => 'Administrative',
                            'Civil' => 'Civil',
                            'Appealed' => 'Appealed',
                            'Labor' => 'Labor',
                        ]),
                    Forms\Components\TextInput::make('case_no')
                        ->required()
                        ->maxLength(255),
                    Select::make('last_action_taken')
                        ->label('Last Action Taken')
                        ->placeholder('Last Action Taken') // Placeholder text
                        ->options([
                            'Plea bargained' => 'Plea bargained',
                            'Warrant of arrest' => 'Warrant of arrest',
                            'Applied probation' => 'Applied probation',
                            'Comp. agreement' => 'Comp. agreement',
                            'Arraign. / prom' => 'Arraign. / prom',
                            'Trial' => 'Trial',
                            'Arraignment' => 'Arraignment',
                            'Desistance' => 'Desistance',
                            'Pre-trial' => 'Pre-trial',
                            'Manifestation' => 'Manifestation',
                            'Disp. measures' => 'Disp. measures',
                            'Trial / prom.' => 'Trial / prom.',
                            'Affidavit Desist.' => 'Affidavit Desist.',
                            'Released bail' => 'Released bail',
                            'Motion to release' => 'Motion to release',
                            'Arraigned' => 'Arraigned',
                            'Hearing' => 'Hearing',
                            'Failed JDR' => 'Failed JDR',
                            'Judicial Affidavit' => 'Judicial Affidavit',
                            'Compromise agreement' => 'Compromise agreement',
                            'Assisted in inquest proc.' => 'Assisted in inquest proc.',
                            'Motion for reconsideration' => 'Motion for reconsideration',
                        ])
                        ->required(),
                    Select::make('status')
                        ->options([
                            'pending' => 'Pending',
                            'resolved' => 'Resolved',
                            'terminated' => 'Terminated',
                        ])
                        ->required()
                        ->label('Status'),
                    DatePicker::make('case_received'),
                    DatePicker::make('date_of_termination'),
                    Select::make('cause_of_action')
                        ->label('Cause of Action')
                        ->required()
                        ->options([
                            'Violation of Sec. 5 of RA 9165' => 'Violation of Sec. 5 of RA 9165',
                            'Violation of Sec. 11 of RA 9165' => 'Violation of Sec. 11 of RA 9165',
                            'Violation of Sec. 12 of RA 9165' => 'Violation of Sec. 12 of RA 9165',
                            'Violation of RA 10591' => 'Violation of RA 10591',
                            'Violation of Sec. 6 of RA 9165' => 'Violation of Sec. 6 of RA 9165',
                            'Violation of Sec. 14 of RA 9165' => 'Violation of Sec. 14 of RA 9165',
                            'Violation of RA 9165' => 'Violation of RA 9165',
                            'Violation of PD 1866' => 'Violation of PD 1866',
                            'Violation of RA 9262' => 'Violation of RA 9262',
                            'Attempted Homicide' => 'Attempted Homicide',
                            'Theft' => 'Theft',
                            'Arson' => 'Arson',
                            'Malicious Mischief' => 'Malicious Mischief',
                            'Less Serious Physical Injuries' => 'Less Serious Physical Injuries',
                            'Malversation of Public Funds' => 'Malversation of Public Funds',
                            'Frustrated Murder' => 'Frustrated Murder',
                            'Violation of RA 9287' => 'Violation of RA 9287',
                            'Robbery' => 'Robbery',
                            'Rape' => 'Rape',
                            'Violation of RA 7610' => 'Violation of RA 7610',
                            'Violation of RA 9287 by RA 9262' => 'Violation of RA 9287 by RA 9262',
                            'Grave Threats' => 'Grave Threats',
                            'Qualified Trafficking,etc.' => 'Qualified Trafficking,etc.',
                            'Violation of RA 9775, etc.' => 'Violation of RA 9775, etc.',
                            'Violation of RA 7610 by RA 9231' => 'Violation of RA 7610 by RA 9231',
                            'Viol. Of Comelec Resolution' => 'Viol. Of Comelec Resolution',
                            'Estafa' => 'Estafa',
                            'Homicide' => 'Homicide',
                            'Murder' => 'Murder',
                            'BL' => 'BL',
                            'Qualified Theft' => 'Qualified Theft',
                            'Acts of Lasc. In Rel to RA 7610' => 'Acts of Lasc. In Rel to RA 7610',
                            'Violation of RA 6539' => 'Violation of RA 6539',
                            'Violation of Sec. 3 of RA 9287' => 'Violation of Sec. 3 of RA 9287',
                            'Statutory Rape' => 'Statutory Rape',
                            'Rape by Sexual Assault' => 'Rape by Sexual Assault',
                            'Illegal Poss. Of Firearms' => 'Illegal Poss. Of Firearms',
                            'Simple Theft' => 'Simple Theft',
                            'Violation of Art. 212 RPC' => 'Violation of Art. 212 RPC',
                            'Robbery with Homicide' => 'Robbery with Homicide',
                            'Reckless Imprudence,etc.' => 'Reckless Imprudence,etc.',
                            'Robbery in an Inhabited Place' => 'Robbery in an Inhabited Place',
                            'Parricide' => 'Parricide',
                            'Qualified Trafficking,etc.' => 'Qualified Trafficking,etc.',
                            'Grave Misconduct' => 'Grave Misconduct',
                            'Viol. Of Sec. 3 of RA 3019' => 'Viol. Of Sec. 3 of RA 3019',
                            'Viol. Of Art. 266 of RPC' => 'Viol. Of Art. 266 of RPC',
                            'Misconduct and Abuse of Authority' => 'Misconduct and Abuse of Authority',
                            'Simple Misconduct' => 'Simple Misconduct',
                        ])
                        ->required(),
                    Select::make('cause_of_termination')
                        ->label('Cause of Termination')
                        ->required()
                        ->options([
                            'Acquitted' => 'Acquitted',
                            'Dismissed with prejudice' => 'Dismissed with prejudice',
                            'Motion to quash granted' => 'Motion to quash granted',
                            'Demurrer to evidence granted' => 'Demurrer to evidence granted',
                            'Provisionally dismissed' => 'Provisionally dismissed',
                            'Convicted to lesser offense' => 'Convicted to lesser offense',
                            'Probation granted' => 'Probation granted',
                            'Won (civil, labor, and administrative)' => 'Won (civil, labor, and administrative)',
                            'Granted lesser award (civil, administrative & labor)' => 'Granted lesser award (civil, administrative & labor)',
                            'Dismissed cases based on compromise agreement (civil & labor)' => 'Dismissed cases based on compromise agreement (civil & labor)',
                            'Favorable Criminal cases for preliminary investigation' => 'Favorable Criminal cases for preliminary investigation',
                            'Pre-trial releases and other dispositions' => 'Pre-trial releases and other dispositions',
                            'Convicted as charged' => 'Convicted as charged',
                            'Lost (civil, administrative & labor)' => 'Lost (civil, administrative & labor)',
                            'Dismissed (civil, administrative & labor)' => 'Dismissed (civil, administrative & labor)',
                            'Unfavorable Criminal cases for preliminary investigation' => 'Unfavorable Criminal cases for preliminary investigation',
                            'Archived' => 'Archived',
                            'Withdrawn' => 'Withdrawn',
                            'Transferred to private lawyer/IBP/etc.' => 'Transferred to private lawyer/IBP/etc.',
                        ]),
                ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('item_no')
                    ->label('Item No')
                    ->toggleable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('control_no')
                    ->label('Control No')
                    ->toggleable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('title_of_case')
                    ->label('Title of Case')
                    ->toggleable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('case_no')
                    ->label('Case No')
                    ->toggleable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('court_body')
                    ->label('Court/Body')
                    ->toggleable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->toggleable()
                    ->badge()->color(fn (string $state): string => match ($state) {
                        'pending' => 'gray',
                        'resolved' => 'success',
                        'terminated' => 'warning',
                    })
                    ->formatStateUsing(fn (string $state): string => __(ucfirst($state)))
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->date('F d, Y h:i A')->timezone('Asia/Manila')
                    ->sortable(),
            ])
            ->filters([
                //TrashedFilter::make(),
            ])
            ->actions([
                ViewAction::make(),
                Tables\Actions\EditAction::make(),
                RestoreAction::make(),
                ActionsDeleteAction::make(),
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
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTransactions::route('/'),
            'create' => Pages\CreateTransaction::route('/create'),
            'edit' => Pages\EditTransaction::route('/{record}/edit'),
        ];
    }
}
