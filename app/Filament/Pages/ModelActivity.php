<?php

namespace App\Filament\Pages;

use App\Models\LoggingInfo;
use Filament\Pages\Page;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Support\Facades\DB;

class ModelActivity extends Page implements HasTable
{
    use InteractsWithTable;
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.model-activity';
    protected static mixed $data ;
    public function __construct()
    {
        self::$data = DB::table('model_as_log');
    }

    public function getTableQuery() : mixed
    {
        return self::$data;
    }
    
}
