@extends('layouts.app')

@section('content')

<!-- breadcrumb -->
<nav area-label="breadcrumb">

	<ol class="breadcrumb">
		<a href="{{ route('home') }}" class="text-decoration-none mr-3">
			<li class="breadcrumb-item">{{ trans('frontend.Home') }}</li>
		</a>
		<li class="breadcrumb-item active">{{ trans('frontend.My Orders') }}</li>
	</ol>
	
</nav>

<div class="card">
    <div class="card-header">{{ trans('frontend.My Orders') }}</div>

    <div class="card-body">

        <table class="table table-bordered table-hover table-dark table-responsive">
        	<thead>
        		<th>{{ trans('frontend.Name') }}</th>
        		<th>{{ trans('frontend.Phone') }}</th>
        		<th>{{ trans('frontend.Address') }}</th>
        		<th>{{ trans('frontend.City') }}</th>
        		<th>{{ trans('frontend.Amount') }}</th>
        		<th>{{ trans('frontend.Pay Method') }}</th>
        		<th>{{ trans('frontend.Status') }}</th>
        		<th>{{ trans('frontend.Check') }}</th>
        	</thead>
        	<tbody>
        		@foreach($orders as $order)
        		<tr>
        			<td>{{ $order->billing_fullname }}</td>
        			<td>{{ $order->billing_phone }}</td>
        			<td>{{ $order->billing_address }}</td>
        			<td>{{ $order->billing_city }}</td>
        			<td>${{ $order->billing_total }}</td>
        			<td>{{ $order->payment_method }}</td>
        			<td  class="text-capitalize">{{ $order->status }}</td>
        			<td>
        				<a href="{{ route('orders.show', $order->id) }}" class="btn btn-success btn-sm">{{ trans('frontend.View Order') }}</a>
        			</td>
        		</tr>
        		@endforeach
        	</tbody>
        </table>
        {{$orders->links()}}
    </div>
</div>

@endsection