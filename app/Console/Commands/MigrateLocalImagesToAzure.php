<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use App\Models\Film;

class MigrateLocalImagesToAzure extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'app:migrate-local-images-to-azure';

    /**
     * The console command description.
     */
    protected $description = 'Migrasi poster & backdrop dari local storage ke Azure Blob Storage';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Mulai migrasi gambar lokal ke Azure Blob...');

        $films = Film::where(function ($query) {
            $query->where('poster_url', 'like', '/storage/%')
                  ->orWhere('backdrop_url', 'like', '/storage/%');
        })->get();

        if ($films->isEmpty()) {
            $this->info('Tidak ada data yang perlu dimigrasi.');
            return Command::SUCCESS;
        }

        foreach ($films as $film) {

            // 🔁 LOOP untuk POSTER & BACKDROP
            foreach ([
                'poster_url'   => 'posters',
                'backdrop_url' => 'backdrops',
            ] as $field => $folder) {

                $currentPath = $film->$field;

                // Skip kalau null atau sudah URL Azure
                if (!$currentPath || !str_starts_with($currentPath, '/storage/')) {
                    continue;
                }

                // Path lokal (tanpa /storage/)
                $localPath = str_replace('/storage/', '', $currentPath);

                if (!Storage::disk('public')->exists($localPath)) {
                    $this->warn("File tidak ditemukan di local: {$localPath}");
                    continue;
                }

                // Ambil file dari local
                $fileContent = Storage::disk('public')->get($localPath);

                // Path tujuan di Azure
                $azurePath = $folder . '/' . basename($localPath);

                // Upload ke Azure
                Storage::disk('azure')->put($azurePath, $fileContent);

                // Update database dengan URL Azure
                $film->update([
                    $field => Storage::disk('azure')->url($azurePath),
                ]);

                $this->info("✔ {$field} dimigrasi: {$azurePath}");
            }
        }

        $this->info('Migrasi selesai. Semua gambar lama sudah pindah ke Azure Blob.');

        return Command::SUCCESS;
    }
}
