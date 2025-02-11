<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class BackupData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'database:backup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Backup Database';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $dbHost =  config('database.connections.mysql.host');
        $dbPort = config('database.connections.mysql.port');
        $dbName =  config('database.connections.mysql.database');
        $dbUser = config('database.connections.mysql.username');
        $dbPassword = config('database.connections.mysql.password');

        $filename = "backup-" . Carbon::now()->format('Ymd-His') . ".sql.gz";
        $backupPath = storage_path('app/backup/' . $filename);

        $command = "mysqldump --user={$dbUser} --password={$dbPassword} --host={$dbHost} --port={$dbPort} {$dbName} | gzip > {$backupPath}";
        // exec('mysqldump -u username -p password database_name > ' . storage_path('app/backup.sql'), $output, $result_code);
        
        $process = Process::fromShellCommandline($command);

        try {
            $process->mustRun();
            $this->info('The backup has been created successfully.');
        } catch (ProcessFailedException $exception) {
            $this->error('The backup process has failed.');
            $this->error($exception->getMessage());
        }
    }
}
