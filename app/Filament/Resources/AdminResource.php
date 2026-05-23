<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AdminResource\Pages;
use App\Models\Admin;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Hash;

class AdminResource extends Resource
{
    protected static ?string $model = Admin::class;

    protected static ?string $navigationIcon = 'heroicon-o-shield-check';

    protected static ?int $navigationSort = 1;

    public static function getNavigationGroup(): ?string
    {
        return __('resources.navigation.group');
    }

    public static function getNavigationLabel(): string
    {
        return __('resources.admin.navigation_label');
    }

    public static function getModelLabel(): string
    {
        return __('resources.admin.model_label');
    }

    public static function getPluralModelLabel(): string
    {
        return __('resources.admin.plural_model_label');
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('name')
                ->label(__('resources.fields.name'))
                ->required()
                ->maxLength(255),
            Forms\Components\TextInput::make('phone')
                ->label(__('resources.fields.phone'))
                ->tel()
                ->required()
                ->unique(ignoreRecord: true)
                ->maxLength(20),
            Forms\Components\TextInput::make('password')
                ->label(__('resources.fields.password'))
                ->password()
                ->revealable()
                ->required(fn (string $operation): bool => $operation === 'create')
                ->dehydrated(fn (?string $state): bool => filled($state))
                ->dehydrateStateUsing(fn (string $state): string => Hash::make($state)),
            Forms\Components\Select::make('status')
                ->label(__('resources.fields.status'))
                ->options([
                    'active' => __('resources.status.active'),
                    'inactive' => __('resources.status.inactive'),
                    'pending_otp' => __('resources.status.pending_otp'),
                    'pending_verification' => __('resources.status.pending_verification'),
                ])
                ->default('active')
                ->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label(__('resources.fields.name'))
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('phone')
                    ->label(__('resources.fields.phone'))
                    ->searchable()
                    ->sortable(),
                Tables\Columns\BadgeColumn::make('status')
                    ->label(__('resources.fields.status'))
                    ->formatStateUsing(fn (string $state): string => __('resources.status.' . $state))
                    ->colors([
                        'success' => 'active',
                        'danger' => 'inactive',
                        'warning' => ['pending_otp', 'pending_verification'],
                    ]),
                Tables\Columns\IconColumn::make('phone_verified_at')
                    ->label(__('resources.fields.verified'))
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('resources.fields.created_at'))
                    ->dateTime()
                    ->sortable(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('role', User::ROLE_ADMIN);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAdmins::route('/'),
            'create' => Pages\CreateAdmin::route('/create'),
            'edit' => Pages\EditAdmin::route('/{record}/edit'),
        ];
    }
}