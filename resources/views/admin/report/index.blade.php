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
                            <div class="col-sm-7">
                                <input type="text" id="searchReports" class="form-control ps-2 pe-5 mb-0"
                                       placeholder="Search Reports">
                            </div>
                            <div class="col-sm-2">
                                <button type="button" class="btn-default btnClearNotification" onclick="updateAllReports()">Clear All</button>
                            </div>
                        </div>
                    </div>
                    <div class="list-followers">
                        @if (count($data) > 0)
                        <table id="example3" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>S.No</th>
                                    <th>Reported By</th>
                                    <th class="no-sort">Post</th>
                                    <th class="no-sort">Reason</th>
                                    <th class="no-sort">Comment</th>
                                    <th class="no-sort">Reported At</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($data as $key => $val)
                                <?php
                                $reason = array();
                                $reason[] = (isset($val->incorrect) && !empty($val->incorrect)) ? "Incorrect Post" : '';
                                $reason[] = (isset($val->inappropriate) && !empty($val->inappropriate)) ? "Inappropriate Post" : '';
                                $reason[] = (isset($val->tolls) && !empty($val->tolls)) ? "Tolls" : '';
                                $reason = implode(', ', array_filter($reason));
                                ?>
                                <tr>
                                    <td>{{ $key + 1  }}</td>
                                    <td>{{ $val->user->user_name }}</td>
                                    @if(isset($val->post))
                                    <td>{{ $val->post->post_text }}</td>
                                    @else
                                    <td>--</td>
                                    @endif
                                    <td>{{ (isset($reason) && !empty($reason))?$reason:'' }}</td>
                                    <td>{{ $val->comments }}</td>                        
                                    <td>{{ $val->created_at }}</td>                        
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




