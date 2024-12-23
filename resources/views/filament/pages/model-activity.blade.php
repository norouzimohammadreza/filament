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
    <table>
        <thead>
        <td>Model</td>
        <td>Level</td>
        <td>Enabled</td>
        </thead>
        <tbody>
        @foreach($logModels as $logModel)
            <tr>
                <td>{{$logModel->model_type}}</td>
                <td>{{\App\Enums\LogLevelEnum::value($logModel->logging_level)}}</td>
                <td>{{$logModel->is_enabled?'True':'False'}}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

</x-filament-panels::page>
