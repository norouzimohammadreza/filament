<x-filament-panels::page>
    @php
        $models = config('farda_activity_log.models');
        for($i=0;$i<sizeof($models);$i++){
            \App\Models\ModelLog::firstOrCreate([
                'model_type' => ($models[$i])
]);
        }
        $logModels =\App\Models\ModelLog::all();
        //dd(\App\Enums\LogLevelEnum::value(1));
        $levels = (\App\Enums\LogLevelEnum::values());
    @endphp
{{$this->table}}
</x-filament-panels::page>
