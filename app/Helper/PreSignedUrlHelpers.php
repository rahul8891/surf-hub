<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PreSignedUrl {
    /*public function __construct(UserService $users)
    {
        $this->users = $users;       
    }*/
   

    function getPreSignedUrl($key, $type) {
        if($type == 'image') {
            $client = Storage::disk('image_s3')->getDriver()->getAdapter()->getClient();
            $bucket = Config::get('filesystems.disks.image_s3.bucket');
        } else { 
            $client = Storage::disk('s3')->getDriver()->getAdapter()->getClient();
            $bucket = Config::get('filesystems.disks.s3.bucket');
        }
        // dd($client);
        // $client = Storage::disk('s3')->getDriver()->getAdapter()->getClient();
        
        $cmd = $client->getCommand('PutObject', [
            'Bucket' => $bucket,
            'Key' => $key
        ]);
        
        $req = $client->createPresignedRequest($cmd, '+20 minutes');
        $presignedUrl = (string) $req->getUri();
        
        return $presignedUrl;
    }

    public static function instance()
     {
         return new PreSignedUrl();
     }
}