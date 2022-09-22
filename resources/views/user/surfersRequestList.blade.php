@extends('layouts.user.user')
@section('content')
@include('layouts/user/user_feed_menu')

<section class="loginWrap registrationWrap">
    <!--<div class="">-->
        <div class="container">
      <!--<div class="col-md-12 col-xl-10">-->

        <div class="card mask-custom">
          <div class="card-body p-4">

            <table class="table mb-0">
              <thead>
                <tr>
                  <th scope="col">Surfer</th>
                  <!--<th scope="col">Post</th>-->
                  <th scope="col">Actions</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($surferRequest as $key => $val)  
                <tr class="fw-normal">
                  <td class="align-middle col-md-4">
                    <span>{{$val['first_name'].' '.$val['last_name']}}</span>
                  </td>
<!--                  <td class="align-middle col-md-6">
                    <span>Call Sam For payments</span>
                  </td>-->
                  
                  <td class="align-middle col-md-2">
                    <a href="{{ route('acceptRejectRequest', [Crypt::encrypt($val['id']),'accept']) }}" class="btn btn-info postReport">Accept</a>
                    <a href="{{ route('acceptRejectRequest', [Crypt::encrypt($val['id']),'reject']) }}" class="btn btn-info postReport">Reject</a>
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>


          </div>
        </div>

      <!--</div>-->
    </div>
  <!--</div>-->
</section>

<script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

@endsection