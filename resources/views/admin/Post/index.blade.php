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
    <div id="loader"></div>
    <div class="card-body">
        <table id="example3" class="table table-bordered">
            <thead>
                <tr>
                    <th>Sr.No</th>
                    <th>Post</th>
                    <th class="no-sort">By User</th>
                    <th class="no-sort">Uploaded On</th>
                    <th class="no-sort">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($posts as $key => $value)
                <tr>
                    <td>{{ ($posts->currentpage()-1) * $posts->perpage() + $key + 1  }}</td>
                    <td>{{ __(ucwords($value->post_text)) }}</td>
                    <td>{{ __(ucwords($value->user_profiles->first_name .' '.$value->user_profiles->last_name)) }}</td>
                    <td>{{ __($value->surf_start_date) }}</td>
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