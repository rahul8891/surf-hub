<?php

use Illuminate\Support\Facades\Auth;
use App\Services\UserService;
use App\Services\PostService;
use App\Models\UserFollow;
use App\Models\Tag;
use App\Models\Upload;
use App\Models\Notification;

class FollowNotification {
    /*public function __construct(UserService $users)
    {
        $this->users = $users;       
    }*/
    function getNotificationCount() {
        $user = new UserService();
        $notificationCount = $user->getNotificationCount();
        //dd($notificationCount);
        return $notificationCount;
    }

    function getPostNotificationsCount() {
        $post = new PostService();
        $notificationCount = $post->getPostNotificationsCount();
        //dd($followRequestNotificationList[0]->follower->user_profiles->first_name);
        return $notificationCount;
    }

    function getPostNotifications() {
        $post = new PostService();
        $getNotifications = $post->getNotifications();
        
        $notificationArray = array();
        foreach ($getNotifications as $key => $value) {
            $notificationArray[$value->id]['notification_id']=$value->id;
            $notificationArray[$value->id]['post_id']=$value->post_id;
            $notificationArray[$value->id]['image']=$value->sender->profile_photo_path;
            $notificationArray[$value->id]['first_name']=$value->sender->user_profiles->first_name;
            $notificationArray[$value->id]['last_name']=$value->sender->user_profiles->last_name;
            $notificationArray[$value->id]['notification_type']=$value->notification_type;
            $notificationArray[$value->id]['created_at']=$value->created_at;
            if(isset($value->post->upload['image']) || isset($value->post->upload['video'])){
                if($value->post->upload['image']){
                    $notificationArray[$value->id]['post_type']='photo';
                }elseif(!$value->post->upload['image'] && $value->post->upload['video']){
                    $notificationArray[$value->id]['post_type']='video';
                }
            }else{
                $notificationArray[$value->id]['post_type']='post';
            }
        }
        return $notificationArray;
    }

     public static function instance()
     {
         return new FollowNotification();
     }
}