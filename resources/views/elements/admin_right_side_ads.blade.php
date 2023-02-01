<div class="right-advertisement">
    @if($res = AdminAds::instance()->getAdminAds('TOPRIGHT BOTTOMRIGHT', Route::currentRouteName()))
    @foreach ($res as $key => $req)
    <img src="{{ env('FILE_CLOUD_PATH').'images/'.$req['user_id'].'/'.$req['image'] }}" alt="advertisement">
    @endforeach
    @else
    <img src="/img/new/advertisement1.png" alt="advertisement">
    <img src="/img/new/advertisement2.png" alt="advertisement">
    @endif
</div>