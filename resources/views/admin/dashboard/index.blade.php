@extends('layouts.admin.admin_layout')
@section('content')
<!-- Info boxes -->
<section class="home-section">
    <div class="container">
        <div class="home-row">
            <div class="my-details-div">
                    @include('layouts.admin.admin_left_sidebar')
            </div>

            <div class="middle-content">
                <div class="table-responsive">
                    <div class="table-strip-wrap">
                        <table class="table table-striped">
                            <caption>Dashboard</caption>
                            <tbody>
                                <tr>
                                    <td>Uploads</td>
                                    <td class="value-table-col">{{ _( number_format(count($uploads) ?? 0) ) }}</td>
                                </tr>
                                <tr>
                                    <td>Active Surf Resorts</td>
                                    <td class="value-table-col">{{ _( number_format($resort) ) }}</td>
                                </tr> 
                                <tr>
                                    <td>Surf Resorts Earn</td>
                                    <td class="value-table-col">0</td>
                                </tr>
                                <tr>
                                    <td>Posts</td>
                                    <td class="value-table-col">{{ _( number_format($totalPost) ) }}</td>
                                </tr>
                                <tr>
                                    <td>Active Users</td>
                                    <td class="value-table-col">{{ _( number_format($totalUser['active']) ) }}</td>
                                </tr>
                                <tr>
                                    <td>Active Photographers</td>
                                    <td class="value-table-col">{{ _( number_format($photographer) ) }}</td>
                                </tr>
                                <tr>
                                    <td>Advertising Revenue</td>
                                    <td class="value-table-col">0</td>
                                </tr>
                                <tr>
                                    <td>Photographers Earn</td>
                                    <td class="value-table-col">0</td>
                                </tr> 
                                <tr>
                                    <td>SurfersEarn</td>
                                    <td class="value-table-col">0</td>
                                </tr>
                                <tr>
                                    <td>Active Advertisers</td>
                                    <td class="value-table-col">{{ _( number_format($advertiser) ) }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- /.row -->
@endsection