@extends('component.master')

@section('title', 'Chart | NSE')

@section('content')
    <div class="container-fluid">

        <div class="row p-2" style="background:#faf3cd">
            <div class="col-md-4"> 
                <span> Nifty Index <span class="dynamic_data_red nifty_index_value">0</span></span>
            </div>
            <div class="col-md-4"> 
                <span> Expriy Date <span class="dynamic_data_red nifty_expiry_date">0</span></span>
            </div>  
            <div class="col-md-4"> 
                <span>Last Updated : <span class="dynamic_data_red" id="datetime"></span></span>
            </div>  
        </div>

        <div class="row">
            <div class="col-md-6">
                <table id="nifty_chart_table" class="table table-sm table-bordered display compact stripe">
                    <thead>
                        <tr>
                            <th colspan="11" style="background: #0cb20c;text-align: center;">NIFTY</th> 
                        </tr>
                        <tr style="background: yellow;">
                           <th>Time</th> 
                           <th>Nifty</th> 
                           <th>CE OI</th> 
                           <th>PE OI</th> 
                           <th>OI DIFF</th> 
                           <th>CE OI CHNG</th> 
                           <th>PE OI CHNG</th> 
                           <th>OI CHNG DIFF</th> 
                           <th>CE VOL</th> 
                           <th>CE VOL</th> 
                           <th>VOL DIFF</th>
                        </tr>
                    </thead>
                    <tbody> 
                    </tbody> 
                </table>
            </div>
            <div class="col-md-6">
                <table id="bank_nifty_chart_table" class="table table-sm table-bordered display compact stripe">
                    <thead>
                        <tr>
                            <th colspan="11" style="background: #0cb20c;text-align: center;">BANK NIFTY</th> 
                        </tr>
                        <tr style="background: yellow;">
                           <th>Time</th> 
                           <th>Nifty</th> 
                           <th>CE OI</th> 
                           <th>PE OI</th> 
                           <th>OI DIFF</th> 
                           <th>CE OI CHNG</th> 
                           <th>PE OI CHNG</th> 
                           <th>OI CHNG DIFF</th> 
                           <th>CE VOL</th> 
                           <th>CE VOL</th> 
                           <th>VOL DIFF</th>
                        </tr>
                    </thead>
                    <tbody> 
                    </tbody> 
                </table>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <canvas id="niftyChartDiff" style="width:100%;"></canvas>
            </div>
            <div class="col-md-6">
                <canvas id="bankNiftyChartDiff" style="width:100%;"></canvas>
            </div>
        </div>

    </div> 
    <script type="text/javascript"> 
        var niftyChartDiffObj;
        var bankNiftyChartDiffObj;
        $( document ).ready(function() {

            toastr.options.positionClass = 'toast-bottom-left';
 
            get_chart_data();

            setInterval(function() { 
               get_chart_data(); 
            }, 60 * 1 * 1000); // 60 * 1000 milsec   // in every 1 minutes

            setInterval(function() {
                var today = new Date();  
                if(today.getHours() < 8 && today.getHours() > 16){
                   save_nifty_nse_data();
                }
            }, 60 * 2 * 1000); // 60 * 1000 milsec. // in every 2 minutes

            $(document).on('click', '.refresh_nse_data', function(e){
                e.preventDefault(); 
                get_chart_data(); 
            });

            $(document).on('change', '.row_range', function(e){ 
                get_chart_data(); 
            });

        });
 


        function get_chart_data() { 

            var today = new Date();  

            $('#datetime').html( today.getHours() + ':' + today.getMinutes() + ' : ' + today.toDateString());


            var row_range = $('.row_range').val();

            var ajaxUrl = "chart-data"; 
            var index = 0;
            $.ajax({
                type: "GET",
                url: ajaxUrl,
                data: "range=" + row_range,
                timeout: 40000, 
                dataType: 'json',
                beforeSend: function(response)
                {
                    $('#pageloading').show();
                },
                success: function(response)
                {   
                    toastr.success('NSE data refreshed successfully!!'); 

                    $('#nifty_chart_table')
                        .on( 'draw.dt',  function () {
                            $("#nifty_chart_table tbody tr").on('click',function(event) {
                                $("#nifty_chart_table tbody tr").removeClass('row_selected');        
                                $(this).addClass('row_selected');
                            });
                        })
                        .dataTable({
                        paging: true,
                        pageLength: 10, 
                        bPaginate: true,
                        bInfo: true,
                        ordering: false, 
                        bFilter: true,
                        bLengthChange: true,
                        searching: true,
                        data: response.nifty, 
                        bDestroy: true, 
                        aoColumns: [  
                            { "defaultContent": '-', 'data': 'format_created_at' },
                            { "defaultContent": '-', 'data': 'strike_price' },
                            { "defaultContent": '-', 'data': 'call_oi_sum' },
                            { "defaultContent": '-', 'data': 'put_oi_sum' },
                            { "defaultContent": '-', 'data': "custom_function",
                                "render": function (custom_function, row, data) { 
                                    var oi_diff = data.call_oi_sum - data.put_oi_sum; 
                                    return oi_diff;
                                }
                            }, 
                            { "defaultContent": '-', 'data': 'call_oichange_sum' },
                            { "defaultContent": '-', 'data': 'put_oichange_sum' },
                            { "defaultContent": '-', 'data': "custom_function",
                                "render": function (custom_function, row, data) { 
                                    var oi_change_diff = data.call_oichange_sum - data.put_oichange_sum; 
                                    return oi_change_diff;
                                }
                            }, 
                            { "defaultContent": '-', 'data': 'call_vol_sum' },
                            { "defaultContent": '-', 'data': 'put_vol_sum' }, 
                            { "defaultContent": '-', 'data': "custom_function",
                                "render": function (custom_function, row, data) { 
                                    var vol_diff = data.call_vol_sum - data.put_vol_sum; 
                                    return vol_diff;
                                }
                            },
                        ], 
                    }); 

                    $('#bank_nifty_chart_table')
                        .on( 'draw.dt',  function () {
                            $("#bank_nifty_chart_table tbody tr").on('click',function(event) {
                                $("#bank_nifty_chart_table tbody tr").removeClass('row_selected');        
                                $(this).addClass('row_selected');
                            });
                        })
                        .dataTable({
                        paging: true,
                        pageLength: 10, 
                        bPaginate: true,
                        bInfo: true,
                        ordering: false, 
                        bFilter: true,
                        bLengthChange: true,
                        searching: true,
                        data: response.banknifty, 
                        bDestroy: true, 
                        aoColumns: [  
                            { "defaultContent": '-', 'data': 'format_created_at' },
                            { "defaultContent": '-', 'data': 'strike_price' },
                            { "defaultContent": '-', 'data': 'call_oi_sum' },
                            { "defaultContent": '-', 'data': 'put_oi_sum' },
                            { "defaultContent": '-', 'data': "custom_function",
                                "render": function (custom_function, row, data) { 
                                    var oi_diff = data.call_oi_sum - data.put_oi_sum; 
                                    return oi_diff;
                                }
                            }, 
                            { "defaultContent": '-', 'data': 'call_oichange_sum' },
                            { "defaultContent": '-', 'data': 'put_oichange_sum' },
                            { "defaultContent": '-', 'data': "custom_function",
                                "render": function (custom_function, row, data) { 
                                    var oi_change_diff = data.call_oichange_sum - data.put_oichange_sum; 
                                    return oi_change_diff;
                                }
                            }, 
                            { "defaultContent": '-', 'data': 'call_vol_sum' },
                            { "defaultContent": '-', 'data': 'put_vol_sum' }, 
                            { "defaultContent": '-', 'data': "custom_function",
                                "render": function (custom_function, row, data) { 
                                    var vol_diff = data.call_vol_sum - data.put_vol_sum; 
                                    return vol_diff;
                                }
                            },
                        ], 
                    });


                    var nifty_time = response.nifty_time;
                    var nifty_oi_diff = response.nifty_oi_diff;
                    var nifty_oi_change_diff = response.nifty_oi_change_diff;
                    var nifty_vol_diff = response.nifty_vol_diff;

                    if(niftyChartDiffObj != undefined)  niftyChartDiffObj.destroy();

                    niftyChartDiffObj = new Chart("niftyChartDiff", {
                      type: "line",
                      data: {
                        labels: nifty_time,
                        datasets: [{
                          data: nifty_oi_diff,
                          label: "OI DIFF",
                          borderColor: "#0cb20c",
                          fill: true,
                          backgroundColor: '#faf3cd73',
                        },{
                          data: nifty_oi_change_diff,
                          label: "OI CHNG DIFF",
                          borderColor: "#f95252",
                          fill: true,
                          backgroundColor: '#faf3cd73',
                        },{
                          data: nifty_vol_diff,
                          label: "Vol DIFF",
                          borderColor: "#ffc107",
                          fill: true,
                          backgroundColor: '#faf3cd73',
                        }]
                      },
                      options: {
                            legend: {
                              display: true,
                              position: 'top', 
                              labels: {
                                fontColor: "darkred",
                              }
                            },
                            title: {
                               display: true,
                               text: "Nifty",
                               fontColor: "darkred",
                              },
                        }
                    }); // end chart oi

                    var bank_nifty_time = response.bank_nifty_time;
                    var bank_nifty_oi_diff = response.bank_nifty_oi_diff;
                    var bank_nifty_oi_change_diff = response.bank_nifty_oi_change_diff;
                    var bank_nifty_vol_diff = response.bank_nifty_vol_diff;

                    if(bankNiftyChartDiffObj != undefined)  bankNiftyChartDiffObj.destroy();

                    bankNiftyChartDiffObj = new Chart("bankNiftyChartDiff", {
                      type: "line",
                      data: {
                        labels: bank_nifty_time,
                        datasets: [{
                          data: bank_nifty_oi_diff,
                          label: "OI DIFF",
                          borderColor: "#0cb20c",
                          fill: true,
                          backgroundColor: '#faf3cd73',
                        },{
                          data: bank_nifty_oi_change_diff,
                          label: "OI CHNG DIFF",
                          borderColor: "#f95252",
                          fill: true,
                          backgroundColor: '#faf3cd73',
                        },{
                          data: bank_nifty_vol_diff,
                          label: "Vol DIFF",
                          borderColor: "#ffc107",
                          fill: true,
                          backgroundColor: '#faf3cd73',
                        }]
                      },
                      options: {
                            legend: {
                              display: true,
                              position: 'top', 
                              labels: {
                                fontColor: "darkred",
                              }
                            },
                            title: {
                               display: true,
                               text: "Nifty",
                               fontColor: "darkred",
                              },
                        }
                    }); // end chart oi
                     
                },
                error: function(response) {
                  toastr.error('Nse API not working <br/> TRY AGAIN');   
                },
                complete: function(response)
                {   
                    $('#pageloading').hide();  
                }
            }); //Ajax End 

        }
    </script>

@endsection