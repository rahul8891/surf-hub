@extends('layouts.admin.master')
@section('content')
<div class="card">
    <div class="card-header bg-primary">
        <h3 class="card-title">Post List</h3>
    </div>
    <div id="error"></div>
    <div class="card-header">
        <!-- a href="{{ route('postCreate')}}" class="btn btn-primary pull-left">Add New Post</a> -->
    </div>
    <!-- /.card-header -->
    <div id="loader"></div>
    <div class="card-body">
        <table id="example3" class="table table-bordered">
            <thead>
                <tr>
                    <th>S.No</th>
                    <th>Reported By</th>
                    <th class="no-sort">Reported To</th>
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
                        $reason[] = (isset($val->incorrect) && !empty($val->incorrect))?"Incorrect Post":'';
                        $reason[] = (isset($val->inappropriate) && !empty($val->inappropriate))?"Inappropriate Post":'';
                        $reason[] = (isset($val->tolls) && !empty($val->tolls))?"Tolls":'';
                        $reason = implode(', ', array_filter($reason));
                    ?>
                    <tr>
                        <td>{{ $key + 1  }}</td>
                        <td>{{ $val->user->user_name }}</td>
                        <td>{{ $val->post->user->user_name }}</td> 
                        <td>{{ $val->post->post_text }}</td>
                        <td>{{ (isset($reason) && !empty($reason))?$reason:'' }}</td>
                        <td>{{ $val->comments }}</td>                        
                        <td>{{ $val->created_at }}</td>                        
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
                        {!! $posts->links() !!}
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