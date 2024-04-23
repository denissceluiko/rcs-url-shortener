<?php

namespace App\Console\Commands;

use App\Models\Image;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class CleanupOrphans extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'image:cleanup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cleans up orphaned images';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Log::channel('cleanup')->info('Starting image cleanup');
        $files = Storage::disk('images')->files();

        $images = Image::all();

        foreach($images as $image) {
            $index = array_search($image->path, $files);

            if ($index === false) {
                continue;
            }

            if (!$image->imageable()->exists()) {
                $image->delete();
                continue;
            }

            $files[$index] = null;
        }

        $deletedCount = 0;
        foreach($files as $file) {
            if ($file != null) {
                Storage::disk('images')->delete($file);
                Log::channel('cleanup')->info("Deleting: $file");
                $deletedCount++;
            }
        }


        Log::channel('cleanup')->info("Total deletions: $deletedCount");

    }
}
