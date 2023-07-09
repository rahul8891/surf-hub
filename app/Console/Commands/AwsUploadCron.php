<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Post;
use App\Models\Upload;
use Aws\S3\S3Client;
use Aws\Exception\AwsException;
use Aws\S3\MultipartUploader;
use Aws\Exception\MultipartUploadException;
use Illuminate\Support\Facades\Storage;
class AwsUploadCron extends Command {

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'AwsUpload:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle() {
        $uploads = Upload::join('posts', 'posts.id', '=', 'uploads.post_id')
                ->where('uploads.aws_uploaded', '0')
                ->where('uploads.is_deleted', '0')
                ->get(['posts.user_id', 'uploads.file_body', 'uploads.id', 'uploads.image', 'uploads.video']);
                
        foreach ($uploads as $value) {            
            try {
                if(!empty($value->image)) {
                    $fileFolder = 'images/' . $value->user_id;
                    $filename = bin2hex(random_bytes(16)).'.'.$value->image;
                    $tempPath = storage_path('app/public/images/' . $filename);
                } elseif(!empty($value->video)) {
                    $fileFolder = 'videos/' . $value->user_id;
                    $filename = bin2hex(random_bytes(16)).'.'.$value->video;
                    $tempPath = storage_path('app/public/videos/' . $filename);    
                }
        
                $data = base64_decode($value->file_body);

                file_put_contents($tempPath, $data);               
                $path = Storage::disk('s3')->putFileAs($fileFolder, $tempPath,$filename);
        
                $upload = Upload::where('id', $value->id)->first();  

                if(!empty($value->image)) {
                    $upload->image = $filename;
                } elseif(!empty($value->video)) {
                    $upload->video = $filename;    
                }

                $upload->aws_uploaded = 1;                  
                $upload->save();                        
            } catch (MultipartUploadException $e) {
                return $e->getMessage();
            }            
        }
    }
}
