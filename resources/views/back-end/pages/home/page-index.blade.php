<div>


    <div class="container-fluid">
        <h2 class="mb-3">Dashboard</h2>


        <div class="row">
            <div class="card col-md-12 pt-4">
                <h4 class="mb-3 text-info"> DATE : {{$mytime}}</h4>

                <form id="searchForm" method="post" action="/webpanel/searchChart">
                    @csrf
                    <div class="form-group row">
                        <div class="col-2">
                            <input class="form-control" name = "DATE" type="date" id="example-date-input">
                        </div>
                      
                        <div class="col-2">
                            <button class="btn btn-primary" type="submit" name="signup" value="Search">Search</button>
                        </div>
                    </div>

                    </from>
                    <table class="table">
                        <thead>
                            <tr>

                                <th>Total Truck Request</th>
                                <th>Total Main Truck</th>
                                <th>Total Additional Truck Request</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <h1 class="text-info p-3">{{$Total_Req}}</h1>
                                </td>
                                <td>
                                    <h1 class="text-info p-3">{{$Total_Req_M}}</h1>
                                </td>
                                <td>
                                    <div class="d-flex p-3">
                                        <div class="mr-4">
                                            <h1 class="text-info">{{$Total_Req_E}}</h1>
                                        </div>
                                        <div>
                                            <div class="text-success"><span class="badge badge-success">{{$Total_Req_E1}}</span> On Process </div>
                                            <div class="text-danger"><span class="badge badge-danger">{{$Total_Req_E2}}</span> Fulfill </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>

                        </tbody>
                    </table>
                    <!-- <div class="row mt-4 mx-3">
                    <div class="card col-md-4  ">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">Total Truck Request : (2) Truck(s)</li>

                        </ul>
                    </div>

                    <div class="card col-md-4">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">Total Main Truck : (3) Truck (s)</li>

                        </ul>
                    </div>

                    <div class="card col-md-4">
                        <ul class="list-group list-group-flush">

                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">Total Additional Truck Request : (4) Truck(s)</li>
                                <li class="list-group-item">- On process : (5) Truck(s)</li>
                                <li class="list-group-item">- On process : (5) Truck(s)</li>
                            </ul>
                    </div>
                </div> -->

            </div>


            <div class="col-md-6 card">
                {!! $chart2->container() !!}
                {!! $chart2->script() !!}
            </div>

            <div class="col-md-6 card">
                {!! $chart->container() !!}
                {!! $chart->script() !!}
            </div>

            <div class="col-md-12">
                <div class="row ">

                    <div class="col-md-8 bg-white pt-4">

                        <div class="col-md-12 bg-primary py-2 text-white font-weight-bold text-center">
                            <h4>Express</h4>
                        </div>
                        <div class="row">

                            <div class="col-md-6">
                                <div class="card mt-4">
                                    <div class="card-header bg-info text-white font-weight-bold">Flash Express</div>
                                    <div class="table card-cody px-4 pt-3">
                                        <table class="table  table-sm table-borderless">
                                            <thead>
                                                <tr>
                                                    <th></th>
                                                    <th>On Process</th>
                                                    <th>Complete</th>
                                                    <th>Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <th scope="row">Linehual</th>
                                                    <td>
                                                <tr>
                                                    <td>Main</td>
                                                    <td>{{$FLH_LH_M1}}</td>
                                                    <td>{{$FLH_LH_M2}}</td>
                                                    <td>{{$FLH_LH_M}}</td>
                                                </tr>
                                                <tr>
                                                    <td>Extra</td>
                                                    <td>{{$FLH_LH_E1}}</td>
                                                    <td>{{$FLH_LH_E2}}</td>
                                                    <td>{{$FLH_LH_E}}</td>
                                                </tr>
                                                </td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">Delivery</th>
                                                    <td>
                                                <tr>
                                                    <td>Main</td>
                                                    <td>{{$FLH_Del_E1}}</td>
                                                    <td>{{$FLH_Del_E2}}</td>
                                                    <td>{{$FLH_Del_E}}</td>
                                                </tr>
                                                </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card mt-4">
                                    <div class="card-header bg-info text-white font-weight-bold">Kerry Express</div>
                                    <div class="table card-cody px-4 pt-3">
                                        <table class="table  table-sm table-borderless">
                                            <thead>
                                                <tr>
                                                    <th></th>
                                                    <th>On Process</th>
                                                    <th>Complete</th>
                                                    <th>Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <th scope="row">Line haul</th>
                                                    <td>
                                                <tr>
                                                    <td>Main</td>
                                                    <td>{{$KEY_LH_M1}}</td>
                                                    <td>{{$KEY_LH_M2}}</td>
                                                    <td>{{$KEY_LH_M}}</td>
                                                </tr>
                                                </td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">Delivery</th>
                                                    <td>
                                                <tr>
                                                    <td>Extra</td>
                                                    <td>{{$KEY_Del_E1}}</td>
                                                    <td>{{$KEY_Del_E2}}</td>
                                                    <td>{{$KEY_Del_E}}</td>
                                                </tr>
                                                </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 ">
                                <div class="card">
                                    <div class="card-header text-white font-weight-bold bg-info">Best Express</div>
                                    <div class="table card-cody px-4 pt-3">
                                        <table class="table  table-sm table-borderless">
                                            <thead>
                                                <tr>
                                                    <th></th>
                                                    <th>On Process</th>
                                                    <th>Complete</th>
                                                    <th>Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <th scope="row">Line haul</th>
                                                    <td>
                                                <tr>
                                                    <td>Main</td>
                                                    <td>{{$BES_LH_M1}}</td>
                                                    <td>{{$BES_LH_M2}}</td>
                                                    <td>{{$BES_LH_M1}}</td>
                                                </tr>
                                                <tr>
                                                    <td>Extra</td>
                                                    <td>{{$BES_LH_E1}}</td>
                                                    <td>{{$BES_LH_E2}}</td>
                                                    <td>{{$BES_LH_E1}}</td>
                                                </tr>
                                                </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 ">
                                <div class="card">
                                    <div class="card-header text-white font-weight-bold bg-info">Shopee Express</div>
                                    <div class="table card-cody px-4 pt-3">
                                        <table class="table  table-sm table-borderless">
                                            <thead>
                                                <tr>
                                                    <th></th>
                                                    <th>On Process</th>
                                                    <th>Complete</th>
                                                    <th>Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <th scope="row">FM Pick up</th>
                                                    <td>
                                                <tr>
                                                    <td>Main</td>
                                                    <td>{{$SHOP_FM_M1}}</td>
                                                    <td>{{$SHOP_FM_M2}}</td>
                                                    <td>{{$SHOP_FM_M}}</td>
                                                </tr>
                                                <tr>
                                                    <td>Extra</td>
                                                    <td>{{$SHOP_FM_E1}}</td>
                                                    <td>{{$SHOP_FM_E2}}</td>
                                                    <td>{{$SHOP_FM_E}}</td>
                                                </tr>
                                                </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 ">
                                <div class="card">
                                    <div class="card-header text-white font-weight-bold bg-info">CJ logistics</div>
                                    <div class="table card-cody px-4 pt-3">
                                        <table class="table  table-sm table-borderless">
                                            <thead>
                                                <tr>
                                                    <th></th>
                                                    <th>On Process</th>
                                                    <th>Complete</th>
                                                    <th>Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <th scope="row">Delivery</th>
                                                    <td>
                                                <tr>
                                                    <td>Main</td>
                                                    <td>{{$CJ_Del_M1}}</td>
                                                    <td>{{$CJ_Del_M2}}</td>
                                                    <td>{{$CJ_Del_M}}</td>
                                                </tr>
                                                </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 ">
                                <div class="card">
                                    <div class="card-header text-white font-weight-bold bg-info">Lazada Express</div>
                                    <div class="table card-cody px-4 pt-3">
                                        <table class="table  table-sm table-borderless">
                                            <thead>
                                                <tr>
                                                    <th></th>
                                                    <th>On Process</th>
                                                    <th>Complete</th>
                                                    <th>Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <th scope="row">FM Pick up</th>
                                                    <td>
                                                <tr>
                                                    <td>Main</td>
                                                    <td>{{$LAZ_FM_M1}}</td>
                                                    <td>{{$LAZ_FM_M2}}</td>
                                                    <td>{{$LAZ_FM_M}}</td>
                                                </tr>
                                                </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 ">
                                <div class="card">
                                    <div class="card-header text-white font-weight-bold bg-info">J&T Express</div>
                                    <div class="table card-cody px-4 pt-3">
                                        <table class="table  table-sm table-borderless">
                                            <thead>
                                                <tr>
                                                    <th></th>
                                                    <th>On Process</th>
                                                    <th>Complete</th>
                                                    <th>Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <th scope="row">Line haul</th>
                                                    <td>
                                                <tr>
                                                    <td>Extra</td>
                                                    <td>{{$JT_LH_E1}}</td>
                                                    <td>{{$JT_LH_E2}}</td>
                                                    <td>{{$JT_LH_E}}</td>
                                                </tr>
                                                </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 ">
                                <div class="card">
                                    <div class="card-header text-white font-weight-bold bg-info">SCG Express</div>
                                    <div class="table card-cody px-4 pt-3">
                                        <table class="table  table-sm table-borderless">
                                            <thead>
                                                <tr>
                                                    <th></th>
                                                    <th>On Process</th>
                                                    <th>Complete</th>
                                                    <th>Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <th scope="row">Line haul</th>
                                                    <td>
                                                <tr>
                                                    <td>Extra</td>
                                                    <td>{{$SCG_LH_E1}}</td>
                                                    <td>{{$SCG_LH_E2}}</td>
                                                    <td>{{$SCG_LH_E}}</td>
                                                </tr>
                                                </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>




                        </div>

                    </div>

                    <div class="col-md-4 bg-white pt-4">

                        <div class="col-md-12 mb-4 bg-primary py-2 text-white font-weight-bold text-center">
                            <h4>Consumer / Retail</h4>
                        </div>
                        <div class="card">
                            <div class="card-header text-white font-weight-bold bg-info">DHL-Big C</div>
                            <div class="table card-cody px-4 pt-3">
                                <table class="table  table-sm table-borderless">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>On Process</th>
                                            <th>Complete</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <th scope="row">DC to store</th>
                                            <td>
                                        <tr>
                                            <td>Extra</td>
                                            <td>{{$DHLBigC_DC_E1}}</td>
                                            <td>{{$DHLBigC_DC_E2}}</td>
                                            <td>{{$DHLBigC_DC_E}}</td>
                                        </tr>
                                        </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header text-white font-weight-bold bg-info">TWD-CJ Mart</div>
                            <div class="table card-cody px-4 pt-3">
                                <table class="table  table-sm table-borderless">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>On Process</th>
                                            <th>Complete</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <th scope="row">DC to store</th>
                                            <td>
                                        <tr>
                                            <td>Main</td>
                                            <td>{{$TWDCJ_DC_M1}}</td>
                                            <td>{{$TWDCJ_DC_M2}}</td>
                                            <td>{{$TWDCJ_DC_M}}</td>
                                        </tr>
                                        </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header text-white font-weight-bold bg-info">NAEVILLE FOOD SERVICE</div>
                            <div class="table card-cody px-4 pt-3">
                                <table class="table  table-sm table-borderless">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>On Process</th>
                                            <th>Complete</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <th scope="row">Delivery</th>
                                            <td>
                                        <tr>
                                            <td>Main</td>
                                            <td>{{$KLine_LH_E1}}</td>
                                            <td>{{$NEVFOOD_Del_M2}}</td>
                                            <td>{{$NEVFOOD_Del_M}}</td>
                                        </tr>
                                        </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header text-white font-weight-bold bg-info">Office Mate</div>
                            <div class="table card-cody px-4 pt-3">
                                <table class="table  table-sm table-borderless">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>On Process</th>
                                            <th>Complete</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <th scope="row">DC to store</th>
                                            <td>{{$Office_DC_E1}}</td>
                                            <td>{{$Office_DC_E2}}</td>
                                            <td>{{$Office_DC_E}}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>


                    </div>

                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="row">

                    <div class="col-md-8 bg-white">

                        <div class="col-md-12 bg-primary py-2 text-white font-weight-bold text-center">
                            <h4>Cold chain</h4>
                        </div>
                        <div class="row">

                            <div class="col-md-6">
                                <div class="card mt-4">
                                    <div class="card-header bg-info text-white font-weight-bold">TFG</div>
                                    <div class="table card-cody px-4 pt-3">
                                        <table class="table  table-sm table-borderless">
                                            <thead>
                                                <tr>
                                                    <th></th>
                                                    <th>On Process</th>
                                                    <th>Complete</th>
                                                    <th>Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <th scope="row">DC to store</th>
                                                    <td>
                                                <tr>
                                                    <td>Main</td>
                                                    <td>{{$TFG_DC_M1}}</td>
                                                    <td>{{$TFG_DC_M2}}</td>
                                                    <td>{{$TFG_DC_M}}</td>
                                                </tr>
                                                </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card mt-4">
                                    <div class="card-header bg-info text-white font-weight-bold">DHL - Makro</div>
                                    <div class="table card-cody px-4 pt-3">
                                        <table class="table  table-sm table-borderless">
                                            <thead>
                                                <tr>
                                                    <th></th>
                                                    <th>On Process</th>
                                                    <th>Complete</th>
                                                    <th>Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <th scope="row">DHL - Makro</th>
                                                    <td>
                                                <tr>
                                                    <td>DC to store</td>
                                                    <td>0</td>
                                                    <td>0</td>
                                                    <td>0</td>
                                                </tr>
                                                </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>




                    </div>

                    <div class="col-md-4 bg-white">

                        <div class="col-md-12 mb-4 bg-primary py-2 text-white font-weight-bold text-center">
                            <h4>Freight forwarder</h4>
                        </div>
                        <div class="card">
                            <div class="card-header text-white font-weight-bold bg-info">K-Line</div>
                            <div class="table card-cody px-4 pt-3">
                                <table class="table  table-sm table-borderless">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>On Process</th>
                                            <th>Complete</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <th scope="row">Line haul</th>
                                            <td>
                                        <tr>
                                            <td>Extra</td>
                                            <td>{{$KLine_LH_E1}}</td>
                                            <td>{{$KLine_LH_E2}}</td>
                                            <td>{{$KLine_LH_E}}</td>
                                        </tr>
                                        </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>


            </div>
        </div>
    </div>
    <script src="http://www.chartjs.org/dist/2.7.3/Chart.bundle.js"></script>
    <script src="http://www.chartjs.org/samples/latest/utils.js"></script>
    <style>
        canvas {
            -moz-user-select: none;
            -webkit-user-select: none;
            -ms-user-select: none;
        }
    </style>
    <script>
        var chartdata = {
            type: 'bar',
            data: {
                labels: <?php echo json_encode($Month); ?>,
                // labels: month,
                datasets: [{
                    label: 'this year',
                    backgroundColor: '#26B99A',
                    borderWidth: 1,
                    data: <?php echo json_encode($Data); ?>
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        }
        var ctx = document.getElementById('canvas').getContext('2d');
        new Chart(ctx, chartdata);
    </script>
