<?php

namespace App\Filament\Moderator\Resources;

use App\Filament\Moderator\Resources\UserResource\Pages;
use App\Filament\Moderator\Resources\UserResource\RelationManagers;
use App\Models\Role;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Hash;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-circle';
    protected static ?string $navigationLabel = 'Users & Borrow';
    protected static ?int $navigationSort = 1; 

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                ->required()
                ->maxLength(255)
                ->doesntStartWith([' ']),
                TextInput::make('email')
                ->required()
                ->maxLength(255)
                ->email(),
                Select::make('role_id')
                // This must be before the options chain method to be overriden
                ->relationship('role', 'name') 
                ->label('Role')
                ->options( function (){ // Admin has all options 
                    if (auth()->user()->isAdmin()){
                        $roles = Role::pluck('name','id')->all();
                        return($roles);
                    }else{
                        return Role::whereNotIn('permission_level', [2,3])
                                ->pluck('name', 'id')
                                ->all();
                    }
                })
                ->required()
                ->helperText('Moderator & Admin should reset their password in login page')
                ->createOptionForm([
                    TextInput::make('name')
                        ->required()
                        ->maxLength(255)
                        ->label('Name of Role')
                        ->helperText('Only Laboratory Head / Admin should create roles')
                        ->disabled(!auth()->user()->isAdmin()),
                ]),
                // Password is disabled, but default to 'password', they just have to reset
                // TextInput::make('password')
                //     ->password()
                //     ->dehydrateStateUsing(fn (string $state): string => Hash::make($state))
                //     ->dehydrated(fn (?string $state): bool => filled($state))
                //     ->required(fn (string $operation): bool => $operation === 'create')
                //     ->hidden(fn (Get $get) => $get('role_id') !== 4)
                //     ->helperText('Unnecessary if User is not moderator/admin'),
                Forms\Components\MarkdownEditor::make('description')
                    ->placeholder("Include additional information\nSection: DCET 3-3\nPosition: Chairperson")
                    ->columnSpan('full'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->deferLoading()
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('role.name')
                    ->disabled(!auth()->user()->isAdmin()),
            ])
            ->filters([
                //
                SelectFilter::make('role')
                    ->relationship('role', 'name')
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->label('Assign & Edit'),
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
            RelationManagers\EquipmentsRelationManager::class,
        ];
    }
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }    
}
