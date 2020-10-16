@extends('layouts.master')
@section('content')
<div class="card">
<div id="error"></div>
<div class="card-header">
   <a href="{{ route('adminUserCreate')}}" class="btn btn-primary pull-left">Add New User</a>
</div>
<!-- /.card-header -->
<div id="loader"></div>
<div class="card-body">
   <table id="example3" class="table table-bordered">
      <thead>
         <tr>
            <th>Sr.No</th>
            <th>Name</th>
            <th class="no-sort">Email</th>
            <th class="no-sort">Status</th>
            <th class="no-sort">Action</th>
         </tr>
      </thead>
      <tbody>
         @foreach($users as $key => $value)
         <tr>
            <td>{{ ($users->currentpage()-1) * $users->perpage() + $key + 1  }}</td>
            <td>{{ __(ucwords($value->user_profiles->first_name .' '.$value->user_profiles->last_name)) }}</td>
            <td>{{ __($value->email) }}</td>
            <td>
               <input type="checkbox" class="changeStatus" name="my-checkbox" data-bootstrap-switch 
               data-off-color="danger" data-id="{{$value->id}}" data-on-color="success" data-on-text="ACTIVATED" 
               data-off-text="Deactivated" @if($value->status == 'ACTIVE') checked @endif>
            </td>
            <td>
               <a class="btn btn-primary btn-sm" href="{{route('adminUserDetails', $value->id)}}"><i class="fas fa-folder"></i> View</a>
               <a class="btn btn-info btn-sm" href="#"><i class="fas fa-pencil-alt"></i> Edit</a>
            </td>
         </tr>
         @endforeach
      </tbody>
   </table>
   @if(!empty($users))
   <div class="text-right margin-r-5" id="resultShow">
      <div class="row d-flex-row">
         <div class="col-md-8"></div>
         <div class="col-md-4" id="next">
            <div class="d-flex justify-content-end">
               {!! $users->links() !!}
            </div>
         </div>
      </div>
      <div>Showing {{($users->currentpage()-1)*$users->perpage()+1}} to {{(($users->currentpage()-1)*$users->perpage())+$users->count()}} of {{$users->total()}} entries</div>
      <div>
         @endif
      </div>
      <!-- /.card-body -->
   </div>
@endsection