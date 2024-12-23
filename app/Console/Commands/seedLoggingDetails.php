<?php

namespace App\Console\Commands;

use App\Models\Post;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use ReflectionClass;
use Spatie\Activitylog\Traits\LogsActivity;

class seedLoggingDetails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:sld';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info("running...");
        dump(Post::class);
        dd(get_declared_classes());
        dd(get_declared_classes());
        dump($this->getClassesThatUseTrait(LogsActivity::class));
    }

    private function getClassesThatUseTrait($traitClass)
    {
        return array_filter(
            get_declared_classes(),
            function ($className) use ($traitClass) {
                $traits = class_uses($className);
                return isset($traits[$traitClass]);
            }
        );
    }
}
