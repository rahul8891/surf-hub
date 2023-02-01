<?php

use Illuminate\Support\Facades\Auth;
use App\Models\AdminAd;

class AdminAds {
    /*public function __construct(UserService $users)
    {
        $this->users = $users;       
    }*/
   

 function getAdminAds($side , $page) {
        $ads = AdminAd::join('pages', 'admin_ads.page_id', '=', 'pages.id')
                    ->where("pages.alias", "=", $page)
//                ->where('admin_ads.ad_position', 'like', '%' . $side . '%')
                ->get();
//        dd($side);
        $counter = 0;
        $sideArr = explode(' ', $side);
        $adsArr = array();
        foreach ($ads as $val) {
            if (str_contains($val->ad_position, $sideArr[0])) {
                $adsArr[$counter]['id'] = $val->id;
                $adsArr[$counter]['user_id'] = $val->user_id;
                $adsArr[$counter]['pos'] = $val->ad_position;
                $adsArr[$counter]['image'] = isset($val->image) ? $val->image : '';
                $counter++;
            } elseif (str_contains($val->ad_position, $sideArr[1])) {
                $adsArr[$counter]['id'] = $val->id;
                $adsArr[$counter]['user_id'] = $val->user_id;
                $adsArr[$counter]['pos'] = $val->ad_position;
                $adsArr[$counter]['image'] = isset($val->image) ? $val->image : '';
                $counter++;
            }
        }
//        echo '<pre>';print_r($adsArr);die;
        return $adsArr;
    }

    public static function instance()
     {
         return new AdminAds();
     }
}