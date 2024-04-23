<?php

namespace App\Console\Commands;

use App\Models\Link;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class GenerateMissingQRCodes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'link:missing-qr';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generates missing QR code images.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $missing = Link::with(['qrcode'])->get();

        foreach ($missing as $link) {
            $this->process($link);
        }
    }

    public function process(Link $link): void
    {
        if (empty($link->qrcode)) {
            $link->makeQR();
            return;
        }

        if (!Storage::disk('images')->exists($link->qrcode->path)) {
            $link->qrcode->delete();
            $link->makeQR();
            return;
        }
    }
}
