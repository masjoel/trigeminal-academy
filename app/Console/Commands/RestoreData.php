<?php

namespace App\Console\Commands;

use App\Models\BackupData;
use Illuminate\Console\Command;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class RestoreData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'database:restore';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Restore database';

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

        $file = BackupData::where('jenis', 'R')->latest()->first();
        $filename = str_replace('.gz', '', $file->nama);
        $restorePath = storage_path('app/restore/' . $filename);
        $command = "mysql --user={$dbUser} --password={$dbPassword} --host={$dbHost} --port={$dbPort} {$dbName} < {$restorePath}";
        
        $process = Process::fromShellCommandline($command);

        try {
            $process->mustRun();
            $this->info('The restore has been created successfully.');
        } catch (ProcessFailedException $exception) {
            $this->error('The restore process has failed.');
            $this->error($exception->getMessage());
        }
    }
}
