<?php

namespace Laradb\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

use Throwable;
use DB;

class BackupCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'laradb:backup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Backup database';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info('Starting database backup...');
        try {
            $tables = DB::select('SHOW TABLES');
            $tables = array_map('current',$tables);
            $this->data['messages'] = [];
            foreach($tables as $table){
                $data = DB::table($table)->get()->toJson();
                Storage::disk('local')->put("db/{$table}.json", $data);
                $this->info("<fg=yellow;bg=blue>{$table} table backup successfully");
            }
            return Command::SUCCESS;
        } catch (Throwable $e) {
            $this->error("Backup failed: {$e->getMessage()}");
            return self::FAILURE;
        }
    }
}
