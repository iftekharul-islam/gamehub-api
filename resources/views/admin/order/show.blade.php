@extends('layouts.app')

@section('content')
    <style>
        @media print {
            .callout {
                display: none;
            }
            #get {
                display: none;
            }
        }
    </style>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Order {{ $order->order_no }}</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="dashboard">Home</a></li>
                            <li class="breadcrumb-item active">Order Details</li>
                        </ol>
                    </div>
                </div>
                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @elseif (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
            <!-- /.container-fluid -->
        </section>
        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="callout callout-info">
                                <h5><i class="fas fa-info"></i> Note:</h5>
                                This page has been enhanced for printing. Click the print button at the bottom of the invoice to test.
                            </div>
                            <!-- Main content -->
                            <div id="invoicePage">
                                <div class="invoice p-3 mb-3">
                                    <!-- title row -->
                                    <div class="row">
                                        <div class="col-12">
                                            <h4>
                                                <i class="far fa-address-card"></i>  Details
                                                <small class="float-right">Date: {{ date('d F, Y', strtotime(now())) }}</small>
                                                <hr>
                                            </h4>
                                        </div>
                                        <!-- /.col -->
                                    </div>
                                    <!-- info row -->
                                    <div class="row invoice-info">
                                        <div class="col-sm-4 invoice-col border-right">
                                            Borrower
                                            <hr>
                                            <address>
                                                <strong>{{ $order->user->name }}</strong><br>
                                                {{ isset($order->user->address->address) ? $order->user->address->address : '' }}<br>
                                                {{ isset($order->user->address->city) ? $order->user->address->city : '' }}<br>
                                                {{ $order->user->email }}<br>
                                                {{ $order->user->phone_number }}<br>
                                            </address>
                                        </div>
                                        <div class="col-sm-4 invoice-col">
                                            Order Info
                                            <hr>
                                            <address>
                                                <strong>Order date :</strong><span> {{ $order->created_at->format('d M Y') }}</span><br>
                                                <!-- <strong>Amount :</strong><span> {{ $order->amount + $order->delivery_charge }} BDT</span><br> -->
                                                <strong>Delivery Status :</strong><span> {{ ucfirst(getOrderDeliveryStatus($order->delivery_status)) }}</span><br>
                                                <strong>Payment method :</strong><span class="badge-success badge">{{ $order->payment_method }}</span><br>
                                                <strong>Payment Status :</strong><span class="badge-success badge">{{ $order->payment_status == 1 ? 'Paid' : 'Unpaid' }}</span><br>
                                            </address>
                                        </div>
                                        <div class="col-sm-4 invoice-col">
                                            Update Order Status
                                            <hr>
                                            <form id="formDeliveryStatus" method="post" action="{{ route('orders.status.update', ['status_type' => 'delivery', 'order_id' => $order->id]) }}" class="mx-auto form-inline mb-3">
                                                @csrf
                                                <div class="false-padding-bottom-form form-group mr-2">
                                                    <select name="status" class="form-control">
                                                        @foreach(config('gamehub.order_delivery_status') as $key => $status)
                                                            <option value="{{$key}}" @if($order->delivery_status == $key) selected @endif>{{ ucfirst($status) }}</option>
                                                        @endforeach
                                                    </select>
                                                    @if ($errors->has('status'))
                                                        <span class="text-danger"><strong>{{ $errors->first('status') }}</strong></span>
                                                    @endif
                                                </div>
                                                <div class="false-padding-bottom-form form-group">
                                                    <button onclick="confirm('formDeliveryStatus')" type="button" class="btn btn-primary btn-submit">Update</button>
                                                </div>
                                            </form>

                                            <form id="formPaymentStatus" method="post" action="{{ route('orders.status.update', ['status_type' => 'payment', 'order_id' => $order->id]) }}" class="mx-auto form-inline ">
                                                @csrf
                                                <div class="false-padding-bottom-form form-group">
                                                    <input type="hidden" name="status" value="{{ $order->payment_status == 1 ? 0 : 1 }}">
                                                    <button onclick="confirm('formPaymentStatus')" type="button" class="btn {{ $order->payment_status == 1 ? 'btn-primary' : 'btn-warning' }} btn-submit">Change payment status to {{ $order->payment_status == 1 ? "Unpaid" : "Paid" }}</button>
                                                </div>
                                            </form>
                                        </div>
                                        <!-- /.col -->
                                    </div>
                                    <!-- /.row -->
                                </div>
                                <div class="invoice p-3 mb-3">
                                    <!-- title row -->
                                    <div class="row">
                                        <div class="col-12">
                                            <h4>
                                                <i class="fas fa-gamepad"></i> Game details
                                                <hr>
                                            </h4>
                                        </div>
                                        <!-- /.col -->
                                    </div>
                                    <!-- info row -->
                                    <div class="row invoice-info">
                                        @if($order->lenders)
                                           
                                            <div class="col-md-12 invoice-col">
                                                <table id="example2" class="table table-bordered table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th>SL</th>
                                                            <th>Game Name</th>
                                                            <th>Amount</th>
                                                            <th>Availability</th>
                                                            <th>Week</th>
                                                            <th>Status</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($order->lenders as $key => $lend)
                                                            <tr>
                                                                <td>{{ $key + 1 }}</td>
                                                                <td><a href="{{ route('game.show', $lend->rent->game_id) }}"> {{ isset($lend->rent->game->name) ? $lend->rent->game->name : ''}}</a></td>
                                                                <td>{{ $lend->lend_cost }}</td>
                                                                <td>{{ isset($lend->rent->availability) ? date('d M, Y', strtotime($lend->rent->availability)) : '' }}</td>
                                                                <td>{{ $lend->lend_week }}</td>
                                                                <!-- <td>{{ ucfirst(getDiskDeliveryStatus($lend->status)) }}</td> -->
                                                                <td>
                                                                    @php $formId = 'game'.$lend->id @endphp
                                                                    <form id="{{$lend->id}}" method="post" action="{{ route('orders.disk.status.update', ['lend_id' => $lend->id]) }}" class="mx-auto form-inline">
                                                                        @csrf
                                                                        <div class="false-padding-bottom-form form-group mr-2">
                                                                            <select name="status" class="form-control">
                                                                                @foreach(config('gamehub.disk_delivery_status') as $key => $status)
                                                                                    <option value="{{$key}}" @if($lend->status == $key) selected @endif>{{ ucfirst($status) }}</option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                        <div class="false-padding-bottom-form form-group">
                                                                            <button onclick="confirm({{$lend->id}})" type="button" class="btn btn-primary btn-submit">Update</button>
                                                                        </div>
                                                                    </form>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        @endif
                                        
                                    </div>

                                    <div class="row">
                                    <div class="col-6 offset-md-6">
                                            <p class="lead">Payment details :</p>
                                            <div class="table-responsive">
                                                <table class="table">
                                                    <tr>
                                                        <th style="width:50%">Subtotal (BDT):</th>
                                                        <td class="text-right">{{ number_format($order->amount, 2) }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Tax (9.3%):</th>
                                                        <td class="text-right">0.00</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Delivery Fee (BDT):</th>
                                                        <td class="text-right">{{ number_format($order->delivery_charge, 2) }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Total (BDT):</th>
                                                        <td id="total" class="text-right">{{ number_format($order->amount + $order->delivery_charge, 2) }}</td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.row -->
                                    <hr>
                                   
                                 
                                    <!-- /.row -->
                                </div>
                                <!-- /.invoice -->
                            </div>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection
@section('js')
    <script type="text/javascript">
        function confirm(form) {
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success ml-2',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: false
            })

            swalWithBootstrapButtons.fire({
                title: 'Confirm',
                text: "Are you sure?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, update it!',
                cancelButtonText: 'No, cancel!',
                reverseButtons: true
            }).then((result) => {
                if (result.value) {
                    document.getElementById(form).submit();
                }
            });
        }
    </script>
@endsection

