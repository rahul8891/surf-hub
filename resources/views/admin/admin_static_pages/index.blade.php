@extends('layouts.master')
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
                        <th>Title</th>
                        <th class="no-sort">Body</th>
                        <th class="no-sort">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pages as $key => $value)
                    <tr>
                        <td>{{ __($value->title) }}</td>
                        <td>{!! substr($value->body,0, 100) !!}</td>
                        <td>
                            <a class="btn btn-info btn-sm"
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