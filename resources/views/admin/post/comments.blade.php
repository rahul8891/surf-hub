@extends( Auth::user() && Auth::user()->user_type == 'ADMIN'  ?  'layouts.admin.admin_layout' : 'layouts.user.new_layout' )
@section('content')

<section class="home-section">
    <div class="container">
        <div class="home-row">
            @include('layouts.admin.admin_left_sidebar')
            <div class="middle-content">
                <div class="follow-wrap">
                    <div class="search-follower">
                        <div class="row align-items-center">
                            <div class="col-sm-3">
                                <label class="">Reports <span class="blue-txt">{{ count($data) }}</span></label>
                            </div>
                        </div>
                    </div>
                    <div class="list-followers">
                        @if (count($data) > 0)
                        <table id="example3" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>S.No</th>
                                    <th>Comment By</th>
                                    <th class="no-sort">Post</th>
                                    <th class="no-sort">Comment</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($data as $key => $val)
                                <tr>
                                    <td>{{ $key + 1  }}</td>
                                    <td>{{ $val->user->user_name }}</td>
                                    @if(isset($val->post))
                                    <td>{{ $val->post->post_text }}</td>
                                    @else
                                    <td>--</td>
                                    @endif
                                    <td>{{ $val->value }}</td>                          
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @else
                        <div class="requests"><div class=""><div class="userInfo mt-2 mb-2 text-center">{{$common['NO_RECORDS']}}</div></div>
                        </div>
                        @endif    
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>

@endsection




