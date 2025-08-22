<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\File;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\DB;

 

class DownloadProductImage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $productId;

    public function __construct($productId)
    {
        $this->productId = $productId;
    }

    public function handle(): void
    {
        $product = DB::table('products')->where("id", $this->productId)->first();

        if (!$product || !$product->temp_image || !$product->temp_image) return;

        try {
            if (!preg_match('/\/file\/d\/(.*?)\//', $product->temp_image, $matches)) {
       
                return;
            }

            $fileId = $matches[1];
            $url = "https://drive.google.com/uc?export=download&id=$fileId";

            $response = Http::timeout(60)->get($url);

       

            $imageName = time() . '_' . uniqid() . '.jpg';
            $path = public_path('product images');

            if (!File::exists($path)) {
                File::makeDirectory($path, 0755, true);
            }

            file_put_contents($path . '/' . $imageName, $response->body());

            DB::table("products")->where("id", $this->productId)->update([
                "image" => $imageName,
                "active" => 1,
        
            ]);
        } catch (\Exception $e) {
            DB::table('products')->where('id', $this->productId)->update(['image_status' => 'failed']);
        }
    }
}
