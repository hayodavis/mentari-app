<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class ShowLatestError extends Command
{
    /**
     * Nama command artisan
     *
     * @var string
     */
    protected $signature = 'error:latest {--lines=50 : Jumlah baris terakhir yang ditampilkan}';

    /**
     * Deskripsi command
     *
     * @var string
     */
    protected $description = 'Menampilkan error terbaru dari storage/logs/laravel.log';

    /**
     * Jalankan perintah.
     */
    public function handle()
    {
        $logPath = storage_path('logs/laravel.log');

        if (!File::exists($logPath)) {
            $this->error("File log tidak ditemukan: {$logPath}");
            return Command::FAILURE;
        }

        $lines = (int) $this->option('lines');
        $content = File::get($logPath);

        $rows = explode("\n", trim($content));
        $lastLines = array_slice($rows, -$lines);

        $this->info("=== Menampilkan {$lines} baris terakhir dari laravel.log ===");
        foreach ($lastLines as $line) {
            $this->line($line);
        }

        return Command::SUCCESS;
    }
}
