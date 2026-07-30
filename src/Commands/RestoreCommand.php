<?php

namespace Laradb\Commands;

use DB;
use Illuminate\Console\Command;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Schema;
use Throwable;

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
        $ignore_tables = ['migrations', 'cache'];
        try {
            Schema::disableForeignKeyConstraints();
            $tables = DB::select('SHOW TABLES');
            $tables = array_map('current',$tables);
            foreach($tables as $table){
                if(!in_array($table, $ignore_tables) && count(DB::table($table)->get())){
                    $this->error("Use restore option only with empty database.");
                    return self::FAILURE;
                }
            }
            foreach($tables as $table){
                if(in_array($table, $ignore_tables)) continue;
                $file = "db/{$table}.json";
                if(!Storage::disk('local')->exists($file)) continue;
                $columns = Schema::getColumnListing($table);
                $records = json_decode(Storage::disk('local')->get($file), true);
                if($records){
                    foreach ($records as $record) {
                        $filtered = Arr::only($record, $columns);
                        DB::select("SET SQL_MODE='ALLOW_INVALID_DATES'");
                        try {
                            DB::table($table)->insert($filtered);
                        } catch (Throwable $e) {
                            $this->error("Duplicate entry");
                        }
                    }
                    $this->info("<fg=yellow;>{$table}</> table restored successfully");
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
