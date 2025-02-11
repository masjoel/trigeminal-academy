<?php

namespace App\Console\Commands;

use App\Models\BackupData;
use Illuminate\Console\Command;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class ExtractGz extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'unzip:gz';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Unzip file gz';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $file = BackupData::where('jenis','R')->latest()->first();
        $filename = $file->nama;

        $command = "gzip -d " . storage_path() . "/app/restore/" . $filename;
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
