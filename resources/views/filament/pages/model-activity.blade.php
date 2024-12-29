<x-filament-panels::page>
    @php
        $models = config('farda_activity_log.models');
                    \App\Models\ModelLogSetting::firstOrCreate([
                'model_type' => 'App'
]);
        for($i=0;$i<sizeof($models);$i++){
            \App\Models\ModelLogSetting::firstOrCreate([
                'model_type' => ($models[$i])
]);
        }
        $logModels =\App\Models\ModelLogSetting::all();
        //dd(\App\Enums\LogLevelEnum::value(1));
        $levels = (\App\Enums\LogLevelEnum::values());
    @endphp
    {{$this->table}}
</x-filament-panels::page>
