@extends('frontEnd.layouts.master')
@section('title','Customer Account')
@section('content')
<section class="customer-section">
    <div class="container">
        <div class="row">
            <div class="col-sm-3">
                <!--<ul>-->
                <!--    <li><a href="{{route('customer.account')}}" class="m-2 btn btn-primary {{request()->is('customer/account')?'active':''}}"><i data-feather="user"></i> My Account</a></li>-->
                <!--    <li><a href="{{route('customer.orders')}}" class="m-2 btn btn-primary {{request()->is('customer/orders')?'active':''}}"><i data-feather="database"></i> My Order</a></li>-->
                <!--    <li><a href="{{route('customer.profile_edit')}}" class="m-2 btn btn-primary {{request()->is('customer/profile-edit')?'active':''}}"><i data-feather="edit"></i> Profile Edit</a></li>-->
                <!--    <li><a href="{{route('customer.change_pass')}}" class="m-2 btn btn-primary {{request()->is('customer/change-password')?'active':''}}"><i data-feather="lock"></i> Change Password</a></li>-->
                <!--    <li><a class="m-2 btn btn-primary" href="{{ route('customer.logout') }}"-->
                <!--        onclick="event.preventDefault();-->
                <!--        document.getElementById('logout-form').submit();"><i data-feather="log-out"></i> Logout</a></li>-->
                <!--    <form id="logout-form" action="{{ route('customer.logout') }}" method="POST" style="display: none;">-->
                <!--        @csrf-->
                <!--    </form>-->
                <!--</ul>-->
                <!--<div class="customer-auth">-->
                <!--    <div class="customer-img">-->
                <!--        <img src="{{asset(Auth::guard('customer')->user()->image)}}" alt="">-->
                <!--    </div>-->
                <!--    <div class="customer-name">-->
                <!--        <p><small>Hello</small></p>-->
                <!--        <p>{{Auth::guard('customer')->user()->name}}</p>-->
                <!--    </div>-->
                <!--</div>-->
                <div class="customer-sidebar">
                    @include('frontEnd.layouts.customer.sidebar')
                </div>
            </div>
            <div class="col-sm-9">
                <div class="customer-content">
                    <h5 class="account-title">My Account</h5>
                    <table class="table">
                        @php
                            $customer = \App\Models\Customer::with('cust_area')->find(Auth::guard('customer')->user()->id);
                        @endphp
                        <tbody>
                            <tr>
                                <td>Name</td>
                                <td>{{$customer->name}}</td>
                            </tr>
                            <tr>
                                <td>Phone</td>
                                <td>{{$customer->phone}}</td>
                            </tr>
                            <tr>
                                <td>Email</td>
                                <td>{{$customer->email}}</td>
                            </tr>
                            <tr>
                                <td>Address</td>
                                <td>{{$customer->address}}</td>
                            </tr>
                            <tr>
                                <td>Disctrict</td>
                                <td>{{$customer->district}}</td>
                            </tr>
                            <tr>
                                <td>Area</td>
                                <td>{{$customer->cust_area?$customer->cust_area->area_name:''}}</td>
                            </tr>
                            <tr>
                                <td>Image</td>
                                <td><img src="{{asset($customer->image)}}" alt="" class="backend_img"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@push('script')
<script src="{{asset('frontEnd/')}}/js/parsley.min.js"></script>
<script src="{{asset('frontEnd/')}}/js/form-validation.init.js"></script>
@endpush