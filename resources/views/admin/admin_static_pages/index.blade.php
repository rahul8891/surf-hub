@extends('layouts.admin.master')
@section('content')
<div class="col-md-12">
    <div id="loader"></div>
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Pages Listing</h3>
        </div>
        <div class="card-body">
            <table id="example3" class="table table-bordered">
                <thead>
                    <tr>
                        <th width="150px">Title</th>
                        <th width="400px" class="no-sort">Body</th>
                        <th width="100px" class="no-sort">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pages as $key => $value)
                    <tr>
                        <td width="150px">{{ __($value->title) }}</td>
                        <td width="400px">{{ $value->body }}</td>
                        <td width="100px">
                            <a id="next" class="btn btn-info btn-sm"
                                href="{{route('adminPageEdit', Crypt::encrypt($value->id))}}"><i
                                    class="fas fa-pencil-alt"></i> Edit</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endsection
