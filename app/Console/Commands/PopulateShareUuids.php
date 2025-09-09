<?php

namespace App\Console\Commands;

use App\Models\TaskList;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class PopulateShareUuids extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:populate-share-uuids';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Populates the share_uuid for existing task lists that are missing it.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Searching for task lists with missing UUIDs...');

        // Busca todas as listas onde o share_uuid é nulo
        $listsToUpdate = TaskList::whereNull('share_uuid')->get();

        if ($listsToUpdate->isEmpty()) {
            $this->info('No lists found to update. All good!');
            return 0;
        }

        $this->info($listsToUpdate->count() . ' list(s) found. Generating UUIDs...');

        // Percorre cada lista encontrada e gera um UUID
        foreach ($listsToUpdate as $list) {
            $list->share_uuid = (string) Str::uuid();
            $list->save();
            $this->line('Updated list ID: ' . $list->id);
        }

        $this->info('Successfully populated all missing UUIDs!');
        return 0;
    }
}