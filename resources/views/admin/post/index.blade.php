@extends('layouts.admin.master')
@section('content')
<div class="card">
    <div class="card-header bg-primary">
        <h3 class="card-title">Post List</h3>
    </div>
    <div id="error"></div>
    <div class="card-header">
        <a href="{{ route('postCreate')}}" class="btn btn-primary pull-left">Add New Post</a>
    </div>
    <!-- /.card-header -->
    <div class="row">
        <div class="col-sm-12 col-md-6">
            <form id="example3_filter" action="{{ route('postIndex') }}" method="GET">
                <label>Search:</label>
                <input type="text" name="search" class="form-control form-control-sm" placeholder="" aria-controls="example3" />
            </form>
        </div>
    </div>
    <div id="loader"></div>
    <div class="card-body">
        <table id="" class="table table-bordered">
            <thead>
                <tr>
                    <th>Sr.No</th>
                    <th>Post</th>
                    <th class="no-sort">By User</th>
                    <th class="no-sort">Uploaded On</th>
                    <th class="no-sort">Add to Feed</th>
                    <th class="no-sort">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($posts as $key => $value)
                <tr>
                    <td>{{ ($posts->currentpage()-1) * $posts->perpage() + $key + 1  }}</td>
                    <td>{{ __(ucwords($value->post_text)) }}</td>
                    <td>{{ __(ucwords($value->user->user_profiles->first_name .' '.$value->user->user_profiles->last_name)) }}</td> 
                    <td>{{ __((date('d-m-Y', strtotime($value->created_at)))) }}</td>
                    <td>
                        <input type="checkbox" data-id="{{ $value->id }}" name="status" class="js-switch" {{ $value->is_feed == 1 ? 'checked' : '' }}></td>
                    <td>
                        <a class="btn btn-primary btn-sm"
                            href="{{route('postDetail', Crypt::encrypt($value->id))}}"><i
                                class="fas fa-folder"></i> View</a>
                        <a class="btn btn-info btn-sm" href="{{route('postEdit', Crypt::encrypt($value->id))}}"><i
                                class="fas fa-pencil-alt"></i> Edit</a>
                        <a class="btn btn-danger btn-sm"
                            href="{{route('deletePost', Crypt::encrypt($value->id))}}"><i
                                class="fas fa-trash-alt"></i> remove</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @if(!empty($posts))
        <div class="text-right margin-r-5" id="resultShow">
            <div class="row d-flex-row">
                <div class="col-md-8"></div>
                <div class="col-md-4" id="next">
                    <div class="d-flex justify-content-end">
                        @if(isset($input['search']) && !empty($input['search']))
                            {!! $posts->appends(['search' => $input['search']])->links()  !!}
                        @else 
                            {!! $posts->links()  !!}
                        @endif
                    </div>
                </div>
            </div>
            <div>Showing {{($posts->currentpage()-1)*$posts->perpage()+1}} to
                {{(($posts->currentpage()-1)*$posts->perpage())+$posts->count()}} of {{$posts->total()}} entries</div>
            <div>
                @endif
            </div>
            <!-- /.card-body -->
        </div>
        @endsection
        
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script>
    $(document).ready(function(){
        let elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));

        elems.forEach(function(html) {
            let switchery = new Switchery(html,  { size: 'small' });
        });
        
        $('.js-switch').change(function () { 
            let status = $(this).prop('checked') === true ? 1 : 0;
            let postId = $(this).data('id');
            $.ajax({
                type: "GET",
                dataType: "json",
                url: '{{ route('statusUpdate') }}',
                data: {'status': status, 'post_id': postId},
                success: function (data) {
                    if(data.statuscode == 200) {
                        $("#errorSuccessmsg").removeClass('alert-danger');
                        $("#errorSuccessmsg").addClass('alert-success');
                        $("#errorSuccessmsg").append('<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+data.message+'</div>');
                    } else {
                        $("#errorSuccessmsg").removeClass('alert-success');
                        $("#errorSuccessmsg").addClass('alert-danger');
                        $("#errorSuccessmsg").append('<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+data.message+'</div>'); 
                    }
                    console.log(data.message);
                }
            });
        });
    });
</script>    