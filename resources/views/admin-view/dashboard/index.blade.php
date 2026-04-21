@extends('layouts.admin.app')

@section('content')
 <div class="content-header">
         <div>
             <nav aria-label="breadcrumb">
                 <ol class="breadcrumb">
                     <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">
                             {{ __('messages.Family Tree Builder') }}</a></li>
                     <li class="breadcrumb-item active" aria-current="page">{{ __('messages.Dashboard') }}</li>
                 </ol>
             </nav>
         </div>
     </div>
<div class="container-fluid px-4">
    <!-- Breadcrumb & Title -->
     
    <div class="d-flex justify-content-between align-items-center mt-4 mb-4">
        <div>
            <h4 class="mb-0">
    Welcome, {{ auth()->guard('admin')->check() ? auth()->guard('admin')->user()->name : 'Guest' }}
</h4>
        </div>
       
    </div>

    <!-- Order Statistics -->
 <div class="mb-4">
    <h5 class="mb-3">Dashboard Overview</h5>
    <div class="row g-3">
        <div class="col-md-3">
            <div class="card bg-light text-center">
                <div class="card-body">
                    <h5 class="card-title mb-1">{{ $orders }}</h5>
                    <p class="card-text small">Total Orders</p>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card bg-success text-white text-center">
                <div class="card-body">
                    <h5 class="card-title mb-1">{{ $members }}</h5>
                    <p class="card-text small">Total Members</p>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card bg-danger text-white text-center">
                <div class="card-body">
                    <h5 class="card-title mb-1">{{ $user }}</h5>
                    <p class="card-text small">Total Users</p>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card bg-info text-white text-center">
                <div class="card-body">
                    <h5 class="card-title mb-1">{{ $messages }}</h5>
                    <p class="card-text small">User Messages</p>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card bg-secondary text-white text-center">
                <div class="card-body">
                    <h5 class="card-title mb-1">{{ $freeusers }}</h5>
                    <p class="card-text small">Free Users</p>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card bg-primary text-white text-center">
                <div class="card-body">
                    <h5 class="card-title mb-1">{{ $standardusers }}</h5>
                    <p class="card-text small">Standard Users</p>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card bg-warning text-white text-center">
                <div class="card-body">
                    <h5 class="card-title mb-1">{{ $silverusers }}</h5>
                    <p class="card-text small">Silver Users</p>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card bg-dark text-white text-center">
                <div class="card-body">
                    <h5 class="card-title mb-1">{{ $goldusers }}</h5>
                    <p class="card-text small">Gold Users</p>
                </div>
            </div>
        </div>
    </div>
</div>


    <!-- Customer & Users -->
<div class="mb-4 mt-5">
    <h5 class="mb-3">Recent Orders</h5>
    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>User Name</th>
                    <th>Package Name</th>
                    <th>Total Amount</th>
                    <th>Created At</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($orderslisting as $order)
                    <tr>
                        <td>{{ $order->id }}</td>
                        <td>{{ $order->user->name }}</td>
                        <td>{{ ucfirst($order->plan->name) }}</td>
                        <td>${{ $order->plan->monthly_price ?? '-' }}</td>
                        <td>{{ $order->created_at->format('Y-m-d H:i') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">No recent orders found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>



</div>
@endsection
