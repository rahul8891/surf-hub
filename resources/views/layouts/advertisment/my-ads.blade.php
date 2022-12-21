@extends('layouts.user.new_layout')
@section('content')
<div class="advertiser-wrap">
            <div class="container">
                <div class="advertiser-header">
                    <h2>My Ads</h2>
                    <a href="{{ route('uploadAdvertisment') }}" class="greyBorder-btn">CREATE ADS</a>
                </div>
                <div class="table-responsive">
                    <table class="table text-center">
                        <thead>
                          <tr>
                            <th scope="col">#</th>
                            <th scope="col">Ads Name</th>
                            <th scope="col">Start Date</th>
                            <th scope="col">End Date</th>
                            <th scope="col">Total Budget</th>
                            <th scope="col">$ Per View</th>
                            <th scope="col">Budget Remaning</th>
                            <th scope="col">Total View</th>
                            <th scope="col">Total Click</th>
                            <th scope="col">Status</th>
                            <th scope="col">Action</th>
                          </tr>
                        </thead>
                        <tbody>
                          @foreach($advertPost as $val)
                          <tr>
                            <td>1</td>
                            <td>{{ $val['post_text'] }}</td>
                            <td>{{ $val['start_date'] }}</td>
                            <td>{{ $val['end_date'] }}</td>
                            <td>{{ $val['your_budget'] }}</td>
                            <td>{{ $val['per_view'] }}</td>
                            <td>{{ $val['your_budget'] }}</td>
                            <td>240</td>
                            <td>120</td>
                            <td>120</td>
                            <td>
                                <a href="{{ route('uploadPreview', Crypt::encrypt($val['post_id'])) }}">View  </a>
                                |  
                                <a href="{{ route('uploadAdvertisment', Crypt::encrypt($val['post_id'])) }}">Edit</a>
                                |
                                <a href="{{ route('deleteAdvert', Crypt::encrypt($val['post_id'])) }}">Delete</a>
                            </td>
                          </tr>
                          @endforeach
                        </tbody>
                      </table>
                </div>
            </div>
        </div>
@endsection