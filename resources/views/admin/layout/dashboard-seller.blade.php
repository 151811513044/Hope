@extends('admin.layout.master')
@section('page-title','Dashboard')

@section('content')
<div class="animated fadeIn">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-flat-color-1"><strong>Total Penghasilan</strong></div>
                <div class="card-body text-center">
                    <div class="stat-widget-five">
                        <div class="stat-content">
                            <div class="text-center dib">
                                <div class="stat-text">
                                    @foreach($total_harga as $th)
                                    @if($total_harga != null)
                                    <h3>Rp. <span class="count">{{$th->harga}}</span></h3>
                                    @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="card text-white bg-flat-color-2">
                        <div class="card-body">
                            <div class="card-left pt-1 float-left">
                                <h3 class="mb-0 fw-r">
                                    <span class="currency float-left mr-1"></span>
                                    @if(!$transaction_detail->isEmpty())
                                    <span class="count">{{$transaction_detail->count()}}</span>
                                    @else <strong>0</strong>
                                    @endif
                                </h3>
                                <p class="text-light mt-1 m-0">Transaction</p>
                            </div><!-- /.card-left -->

                            <div class="card-right float-right text-right">
                                <i class="icon fade-5 icon-lg pe-7s-credit"></i>
                            </div><!-- /.card-right -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="card text-white bg-flat-color-6">
                        <div class="card-body">
                            <div class="card-left pt-1 float-left">
                                <h3 class="mb-0 fw-r">
                                    @foreach($total_harga as $th)
                                    @if($th != null)
                                    <span class="count">{{$th->qty}}</span>
                                    @endif
                                    @endforeach
                                </h3>
                                <p class="text-light mt-1 m-0">Product Sold</p>
                            </div><!-- /.card-left -->

                            <div class="card-right float-right text-right">
                                <i class="icon fade-5 icon-lg pe-7s-cart"></i>
                            </div><!-- /.card-right -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="clearfix"></div>
    <!-- Orders -->
    <div class="orders">
        <div class="row">
            <div class="col-xl-6">
                <div class="card">
                    <div class="card-body">
                        <h4 class="box-title">Pembelian Terbaru </h4>
                    </div>
                    <div class="card-body--">
                        <div class="table-stats order-table ov-h">
                            <table class="table ">
                                <thead>
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>Invoice ID</th>
                                        <th>Product</th>
                                        <th>Quantity</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($transaction_detail->take(10) as $td)
                                    @if(!empty($td))
                                    <tr>
                                        <td>{{date('d F Y', strtotime($td->tanggal))}}</td>
                                        <td>{{$td->uuid}} </td>
                                        <td> <span class="name">{{$td->nama_product}}</span> </td>
                                        <td> <span class="product">{{$td->quantity}}</span> </td>
                                        <td><span class="count">{{$td->total_harga}}</span></td>
                                    </tr>
                                    @endif
                                    @empty
                                    <tr>
                                        <td colspan="5" class="text-center">Data Not Available</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div> <!-- /.table-stats -->
                    </div>
                </div> <!-- /.card -->
            </div> <!-- /.col-lg-8 -->

            <div class="col-xl-6">
                <div class="row">
                    <div class="col-lg-6 col-xl-12">
                        <div class="card br-0">
                            <div class="card-body">
                                <select name="year" class="form-control col-4" id="">
                                    <option selected>- Select Year -</option>
                                    <option value="2021">2021</option>
                                    <option value="2022">2022</option>
                                </select>
                            </div>
                            <div class="card-body--">
                                @if(!empty($transaction_detail))
                                <div class="" id="chartTrans"></div>
                                @endif
                            </div>
                        </div>
                    </div><!-- /.card -->
                </div>
            </div>
        </div> <!-- /.col-md-4 -->
    </div>
</div>
@endsection
@section('script')
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
@include('sweet::alert')
<script src="https://code.highcharts.com/highcharts.js"></script>
@if(!empty($transaction_detail))
<script>
    var trans = <?php echo json_encode($data_trans) ?>;
    Highcharts.chart('chartTrans', {
        title: {
            text: "Transaction"
        },
        xAxis: {
            categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
        },
        yAxis: {
            title: {
                text: "Number of Transaction"
            }
        },
        series: [{
            name: "Order Total",
            data: trans
        }],
    });
</script>
@endif
@endsection