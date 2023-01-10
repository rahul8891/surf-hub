<?php

use Illuminate\Support\Facades\Auth;
use App\Models\AdvertPost;

class showAdvertisment {
    /*public function __construct(UserService $users)
    {
        $this->users = $users;       
    }*/
   

 function getAdvertisment() {
        $advertisment = AdvertPost::OrderBy('your_budget', 'ASC')
                        ->get();
        $counter = 0;
        $advertismentArr = array();
        foreach ($advertisment as $val) {
            $advertismentArr[$counter]['id'] = $val->id;
            $advertismentArr[$counter]['user_id'] = $val->advert_post->user_id;
            $advertismentArr[$counter]['ad_link'] = $val->ad_link;
            $advertismentArr[$counter]['image'] = isset($val->get_media->image)?$val->get_media->image:'';
            $advertismentArr[$counter]['video'] = isset($val->get_media->video)?$val->get_media->video:'';
            $counter++;
        }
//        echo '<pre>';print_r($advertismentArr);die;
        return $advertismentArr;
    }

    public static function instance()
     {
         return new showAdvertisment();
     }
}