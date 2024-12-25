<?php

namespace App\Livewire;

use App\Models\ModelLog;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Pages\Concerns\InteractsWithFormActions;
use Filament\Widgets\Widget;

class LogSettingWidget2 extends Widget implements HasForms, HasActions
{
    use InteractsWithForms;
    use InteractsWithActions;
    use InteractsWithFormActions;

    protected static string $view = "test";

    public ?array $data = [];

    public function mount()
    {
        $this->form->fill([]);
    }

    public function form(Form $form): Form
    {
        return $form
            ->model(ModelLog::where('model_type', 'App')->first())
            ->statePath('data')
            ->schema([
                Section::make()->schema([
                    TextInput::make('model_type')->label('App'),
                    ToggleButtons::make('is_enabled')->label('Enabled')
                        ->inline(),
                ])
            ]);
    }
}
