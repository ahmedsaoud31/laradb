<?php

namespace Laradb\Commands;

use Illuminate\Console\Command;

class RestoreCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'laradb:restore';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Restore database';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info('Starting database restore...');
        try {
            Schema::disableForeignKeyConstraints();
            $tables = DB::select('SHOW TABLES');
            $tables = array_map('current',$tables);
            foreach($tables as $table){
                $file = "db/{$table}.json";
                if(!file_exists($file)) continue;
                $columns = Schema::getColumnListing($table);
                $records = json_decode(Storage::disk('local')->get($file), true);
                if($records){
                    foreach ($records as $record) {
                        $filtered = Arr::only($record, $columns);
                        DB::select("SET SQL_MODE='ALLOW_INVALID_DATES'");
                        DB::table($table)->insert($filtered);
                    }
                    $this->info("{$table} table restored successfully");
                }
            }
            Schema::enableForeignKeyConstraints();
            return Command::SUCCESS;
        } catch (Throwable $e) {
            $this->error("Backup failed: {$e->getMessage()}");
            return self::FAILURE;
        }
    }
}
