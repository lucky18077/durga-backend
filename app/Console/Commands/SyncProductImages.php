<?php

namespace App\Console\Commands;

namespace App\Console\Commands;

use App\Jobs\DownloadProductImage;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class SyncProductImages extends Command
{
    protected $signature = 'app:sync-product-images';
    protected $description = 'Dispatch jobs to sync product images';

    public function handle()
    {
        $products = DB::table('products')
            ->whereNotNull("temp_image")
            ->whereNull("image")
            ->limit(10)
            ->pluck('id');

        foreach ($products as $id) {
            DownloadProductImage::dispatch($id);
        }

        $this->info('Dispatched image sync jobs for ' . $products->count() . ' products.');
    }
}
