@extends('component.master')

@section('title', 'NIFTY | NSE')

@section('content')
    <div class="container-fluid">

        <div class="row p-2" style="background:#faf3cd">
            <div class="col-md-4"> 
                <span> Nifty Index : <span class="dynamic_data_red nifty_index_value">0</span></span>
            </div>
            <div class="col-md-4"> 
                <span> Expriy Date : <span class="dynamic_data_red nifty_expiry_date">0</span></span>
            </div>  
            <div class="col-md-4"> 
                <span>Last Updated : <span class="dynamic_data_red" id="datetime"></span></span>
            </div>  
        </div>

        <div class="row">
            <div class="col-md-4"> 
                <table class="table table-sm table-bordered display compact stripe">
                    <tr>
                        <td><strong>Title</strong></td>
                        <td><strong>Value</strong></td>
                        <td><strong>Strike Price</strong></td>
                    <tr>
                    <tr>
                        <td>Max CE OI</td>
                        <td><span class="dynamic_data_green max_ce_oi">0</span></td>
                        <td><span class="dynamic_data_green max_ce_oi_strike">0</span></td>
                    <tr>
                    <tr>
                        <td>Max CE_OICHANGE</td>
                        <td><span class="dynamic_data_green max_ce_oichange">0</span></td>
                        <td><span class="dynamic_data_green max_ce_oichange_strike">0</span></td>
                    <tr>
                    <tr>
                        <td>Max PE OI</td>
                        <td><span class="dynamic_data_red max_pe_oi">0</span></td>
                        <td><span class="dynamic_data_red max_pe_oi_strike">0</span></td>
                    <tr>
                    <tr>
                        <td>Max PE_OICHANGE</td>
                        <td><span class="dynamic_data_red max_pe_oichange">0</span></td>
                        <td><span class="dynamic_data_red max_pe_oichange_strike">0</span></td>
                    <tr>

                </table>
            </div> 

            <div class="col-md-4"> 
                <table class="table table-sm table-bordered display compact stripe">
                    <tr>
                        <td>CE OI</td>
                        <td><span class="dynamic_data_green">0</span></td>
                        <td>PE OI</td>
                        <td><span class="dynamic_data_red">0</span></td>
                        <td>INTRADAY</td>
                        <td>POSITIONAL</td>
                    <tr>
                    <tr>
                        <td>CE OI CHANGE</td>
                        <td><span class="dynamic_data_green">0</span></td>
                        <td>PE OI CHANGE</td>
                        <td><span class="dynamic_data_red">0</span></td>
                        <td><span class="dynamic_data_red">FALSE</span></td>
                        <td><span class="dynamic_data_red">FALSE</span></td>
                    <tr>
                    <tr>
                        <td>CE VOLUME</td>
                        <td><span class="dynamic_data_green">0</span></td>
                        <td>PE VOLUME</td>
                        <td><span class="dynamic_data_red">0</span></td>
                    <tr>  
                </table>
            </div> 

            <div class="col-md-4"> 
                <table class="table table-sm table-bordered display compact stripe">
                    <tr>
                        <td>Total CE OI</td><td><span class="dynamic_data_green total_put_oi">0</span></td> 
                        <td>Total CE VOL</td><td><span class="dynamic_data_green total_put_volume">0</span></td> 
                    <tr>
                    <tr>
                        <td>Total PE OI</td><td><span class="dynamic_data_red total_call_oi">0</span></td> 
                        <td>Total PE VOL</td><td><span class="dynamic_data_red total_call_volume">0</span></td>  
                    <tr> 
                    <tr> 
                        <td>Total PCR OI</td><td><span class="dynamic_data_red total_pcr_oi">0</span></td> 
                        <td>Total PCR VOL</td><td><span class="dynamic_data_red total_pcr_volume">0</span></td>      
                    <tr> 
                </table>
            </div> 
        </div>

        <!-- 
            PCR OI if > 1.7 can  BIG crash
            PCR OI if < 0.8 can 

         -->

        <div class="row">
            <div class="col"> 
                <table id="nse_data_table" class="table table-sm table-bordered display compact stripe">
                    <thead>
                        <tr>
                            <th colspan="10" style="background: #0cb20c;text-align: center;">Call</th>
                            <th colspan="" style="background: darkred; color: white;text-align: center;">NIFTY</th>
                            <th colspan="10" style="background: #f95252;text-align: center;">Put</th> 
                            <th colspan="3" style="background: darkred;color: white;text-align: center;">Calculations</th> 
                        </tr>
                        <tr style="background: yellow;">
                           <th title="Open Interest in contracts">OI</th>
                           <th title="Change in Open Interest (Contracts)">Chng In OI</th>
                           <th title="Volume in Contracts">Volume</th>
                           <th title="Implied Volatility">IV</th>
                           <th title="Last Traded Price">LTP</th>
                           <th title="Change w.r.t to Previous Close">Chng</th>
                           <th title="Best Bid/Buy Qty">BidQty</th>
                           <th title="Best Bid/Buy Price">Bid Price</th>
                           <th title="Best Ask/Sell Price">Ask Price</th>
                           <th title="Best Ask/Sell Qty">Ask ty</th>
                           <th>Strike Price</th>
                           <th title="Best Bid/Buy Qty">Bid Qty</th>
                           <th title="Best Bid/Buy Price">Bid Price</th>
                           <th title="Best Ask/Sell Price">Ask Price</th>
                           <th title="Best Ask/Sell Qty">Ask Qty</th>
                           <th title="Change w.r.t to Previous Close">Chng</th>
                           <th title="Last Traded Price">LTP</th>
                           <th title="Implied Volatility">IV</th>
                           <th title="Volume in Contracts">Volume</th>
                           <th title="Change in Open Interest (Contracts)">Chng In OI</th>
                           <th title="Open Interest in contracts">OI</th>
                           <th title="calculation PCR">PCR</th> 
                        </tr>
                    </thead>
                    <tbody> 
                    </tbody>
                    <tfoot> 
                        <tr style="background: yellow;">
                           <th title="Open Interest in contracts">OI</th>
                           <th title="Change in Open Interest (Contracts)">Chng In OI</th>
                           <th title="Volume in Contracts">Volume</th>
                           <th title="Implied Volatility">IV</th>
                           <th title="Last Traded Price">LTP</th>
                           <th title="Change w.r.t to Previous Close">Chng</th>
                           <th title="Best Bid/Buy Qty">BidQty</th>
                           <th title="Best Bid/Buy Price">Bid Price</th>
                           <th title="Best Ask/Sell Price">Ask Price</th>
                           <th title="Best Ask/Sell Qty">Ask ty</th>
                           <th>Strike Price</th>
                           <th title="Best Bid/Buy Qty">Bid Qty</th>
                           <th title="Best Bid/Buy Price">Bid Price</th>
                           <th title="Best Ask/Sell Price">Ask Price</th>
                           <th title="Best Ask/Sell Qty">Ask Qty</th>
                           <th title="Change w.r.t to Previous Close">Chng</th>
                           <th title="Last Traded Price">LTP</th>
                           <th title="Implied Volatility">IV</th>
                           <th title="Volume in Contracts">Volume</th>
                           <th title="Change in Open Interest (Contracts)">Chng In OI</th>
                           <th title="Open Interest in contracts">OI</th>
                           <th title="calculation PCR">PCR</th> 
                        </tr> 
                        <tr>
                            <th colspan="10" style="background: #0cb20c;text-align: center;">Call</th>
                            <th colspan="" style="background: darkred; color: white;text-align: center;">NIFTY</th>
                            <th colspan="10" style="background: #f95252;text-align: center;">Put</th> 
                            <th colspan="3" style="background: darkred;color: white;text-align: center;">Calculations</th> 
                        </tr> 
                    </tfoot>
                    <tfoot>
                        <th class="dynamic_data_green selected_put_oi_sum">0</th>
                        <th colspan="" class="dynamic_data_green selected_call_oichange_sum"></th> 
                        <th class="dynamic_data_green selected_put_vol_sum">0</th> 
                        <th colspan="15"></th>  
                        <th class="dynamic_data_red selected_call_vol_sum">0</th>
                        <th colspan="" class="dynamic_data_red selected_put_oichange_sum"></th> 
                        <th class="dynamic_data_red selected_call_oi_sum">0</th> 
                        <th class="dynamic_data_red selected_pcr_oi">0</th>  
                    </tfoot>
                </table> 
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <canvas id="oiChartLine" style="width:100%;"></canvas>
            </div>
            <div class="col-md-6">
                <canvas id="oiChangeChartLine" style="width:100%;"></canvas>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <canvas id="oiChartBar" style="width:100%;"></canvas>
            </div>
            <div class="col-md-6">
                <canvas id="oiChangeChartBar" style="width:100%;"></canvas>
            </div>
        </div>

    </div> 
    <script type="text/javascript"> 
        var oiLineChartObj;
        var oiChangeLineChart;


        var oiBarChartObj;
        var oiChangeBarChart;

        $( document ).ready(function() {

            toastr.options.positionClass = 'toast-bottom-left';

            $('#nse_data_table').dataTable({
                paging: false,
                pageLength: 100, 
                bPaginate: true,
                bInfo: true,
                ordering: false, 
                bFilter: true,
                bLengthChange: true,
                searching: true, 
                bDestroy: true, 
            }); 

            get_nifty_nse_data();

            setInterval(function() {
                var today = new Date();  
                if(today.getHours() > 9 && today.getHours() < 16){
                   get_nifty_nse_data();
                } 
            }, 60 * 1 * 1000); // 60 * 1000 milsec   // in every 1 minutes

            // setInterval(function() {
            //     var today = new Date();  
            //     if(today.getHours() > 9 && today.getHours() < 16){
            //        save_nifty_nse_data();
            //     }
            // }, 60 * 2 * 1000); // 60 * 1000 milsec. // in every 2 minutes

            $(document).on('click', '.refresh_nse_data', function(e){
                e.preventDefault(); 
                get_nifty_nse_data(); 
                //save_nifty_nse_data();
            });

            $(document).on('change', '.row_range', function(e){ 
                get_nifty_nse_data(); 
            });

        });

        // function save_nifty_nse_data() {
        //     var ajaxUrl = "save-nifty-nse-data";
        //     var index = 0;
        //     $.ajax({
        //         type: "GET",
        //         url: ajaxUrl,
        //         timeout: 40000, 
        //         dataType: 'json',
        //         beforeSend: function(response)
        //         {
        //             //$('#pageloading').show();
        //         },
        //         success: function(response)
        //         { 
        //             //toastr.success('NSE data saved successfully!!'); 
        //         },
        //         error: function(response) {
        //             toastr.error('Error In saving NSE data.<br/> TRY AGAIN!'); 
        //         },
        //         complete: function(response)
        //         {   
        //             //$('#pageloading').hide();  
        //         }
        //     }); //Ajax End
        // }


        function get_nifty_nse_data() {


            var today = new Date();  

            $('#datetime').html( today.getHours() + ':' + today.getMinutes() + ' : ' + today.toDateString());


            var row_range = $('.row_range').val();

            var ajaxUrl = "get-nifty-nse-data"; 
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

                    $('.max_ce_oi').html(response.max_ce_oi);
                    $('.max_ce_oi_strike').html(response.max_ce_oi_strike);
                    $('.max_ce_oichange').html(response.max_ce_oichange);
                    $('.max_ce_oichange_strike').html(response.max_ce_oichange_strike);
                    $('.max_pe_oi').html(response.max_pe_oi);
                    $('.max_pe_oi_strike').html(response.max_pe_oi_strike);
                    $('.max_pe_oichange').html(response.max_pe_oichange);
                    $('.max_pe_oichange_strike').html(response.max_pe_oichange_strike);

                    $('.selected_put_oi_sum').html(response.selected_put_oi_sum);
                    $('.selected_put_vol_sum').html(response.selected_put_vol_sum);
                    $('.selected_call_vol_sum').html(response.selected_call_vol_sum);
                    $('.selected_call_oi_sum').html(response.selected_call_oi_sum);  
                    $('.selected_pcr_oi').html(response.selected_pcr_oi.toFixed(2)); 

                    $('.selected_call_oichange_sum').html(response.selected_call_oichange_sum);  
                    $('.selected_put_oichange_sum').html(response.selected_put_oichange_sum);  


                    $('.total_call_oi').html(response.total_call_oi);
                    $('.total_call_volume').html(response.total_call_volume);
                    $('.total_put_oi').html(response.total_put_oi);
                    $('.total_put_volume').html(response.total_put_volume); 

                    $('.total_pcr_oi').html(response.total_pcr_oi.toFixed(2));
                    $('.total_pcr_volume').html(response.total_pcr_volume.toFixed(2));

                    if(oiLineChartObj != undefined)  oiLineChartObj.destroy();

                    oiLineChartObj = new Chart("oiChartLine", {
                      type: "line",
                      data: {
                        labels: response.chartdata.strike,
                        datasets: [{
                          data: response.chartdata.ceoi,
                          label: "Call Open Interest",
                          borderColor: "#f95252",
                          fill: true,
                          backgroundColor: '#faf3cd73',
                        },{
                          data: response.chartdata.peoi,
                          label: "Put Open Interest",
                          borderColor: "#0cb20c",
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
                               text: "Open Interest",
                               fontColor: "darkred",
                              },
                        }
                    }); // end chart oi

                    if(oiChangeLineChart != undefined)  oiChangeLineChart.destroy(); 

                    oiChangeLineChart =new Chart("oiChangeChartLine", {
                      type: "line",
                      data: {
                        labels: response.chartdata.strike,
                        datasets: [{
                          borderColor: '#f95252',
                          label: "Call Change In Open Interest",
                          data: response.chartdata.cechangeoi,
                          fill: true,
                          backgroundColor: '#faf3cd73',
                        },
                        {
                          borderColor: '#0cb20c',
                          label: "Put Change In Open Interest",
                          data: response.chartdata.pechangeoi,
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
                          text: "Change In Open Interest",
                          fontColor: "darkred",
                        }
                      }
                    });

                     if(oiBarChartObj != undefined)  oiBarChartObj.destroy();

                    oiBarChartObj = new Chart("oiChartBar", {
                      type: "bar",
                      data: {
                        labels: response.chartdata.strike,
                        datasets: [{
                          data: response.chartdata.ceoi,
                          label: "Call Open Interest",
                          borderColor: "#f95252",
                          fill: true,
                          backgroundColor: '#f95252',
                        },{
                          data: response.chartdata.peoi,
                          label: "Put Open Interest",
                          borderColor: "#0cb20c",
                          fill: true,
                          backgroundColor: '#0cb20c',
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
                               text: "Open Interest",
                               fontColor: "darkred",
                              },
                        }
                    }); // end chart oi

                    if(oiChangeBarChart != undefined)  oiChangeBarChart.destroy(); 

                    oiChangeBarChart =new Chart("oiChangeChartBar", {
                      type: "bar",
                      data: {
                        labels: response.chartdata.strike,
                        datasets: [{
                          borderColor: '#0cb20c',
                          label: "Call Change In Open Interest",
                          data: response.chartdata.pechangeoi,
                          fill: true,
                          backgroundColor: '#f95252',
                        },
                        {
                          borderColor: '#f95252',
                          label: "Put Change In Open Interest",
                          data: response.chartdata.cechangeoi,
                          fill: true,
                          backgroundColor: '#0cb20c',
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
                          text: "Change In Open Interest",
                          fontColor: "darkred",
                        }
                      }
                    });

                    response = response.tabledata;

                    $('.nifty_index_value').html(response[0].CE.underlyingValue);
                    $('.nifty_expiry_date').html(response[0].expiryDate);

                    $('#nse_data_table')
                        .on( 'draw.dt',  function () {
                            $("#nse_data_table tbody tr").on('click',function(event) {
                                $("#nse_data_table tbody tr").removeClass('row_selected');        
                                $(this).addClass('row_selected');
                            });
                            $("#nse_data_table tbody td").on('click',function(event) {
                                $("#nse_data_table tbody td").removeClass('cell_selected');        
                                $(this).addClass('cell_selected');
                            });
                            //$("#nse_data_table").unhighlight().highlight($('#searchme').val());
                        })
                        .dataTable({
                        paging: false,
                        pageLength: 100, 
                        bPaginate: true,
                        bInfo: true,
                        ordering: false, 
                        bFilter: true,
                        bLengthChange: true,
                        searching: true,
                        data: response, 
                        bDestroy: true, 
                        createdRow: (row, data, dataIndex, cells) => {
                            var strikePrice= data.strikePrice;   
                            if (strikePrice  > data.CE.underlyingValue && index == 0) {
                                index = data.CE.underlyingValue; 
                                $(row).find('td:eq(10)').addClass('index-cell');
                            }
                            if (strikePrice  < data.CE.underlyingValue) { 
                                $(row).find('td:eq(0)').addClass('ce-itm');
                                $(row).find('td:eq(1)').addClass('ce-itm');
                                $(row).find('td:eq(2)').addClass('ce-itm');
                                $(row).find('td:eq(3)').addClass('ce-itm');
                                $(row).find('td:eq(4)').addClass('ce-itm');
                                $(row).find('td:eq(5)').addClass('ce-itm');
                                $(row).find('td:eq(6)').addClass('ce-itm');
                                $(row).find('td:eq(7)').addClass('ce-itm');
                                $(row).find('td:eq(8)').addClass('ce-itm');
                                $(row).find('td:eq(9)').addClass('ce-itm'); 
                            }
                            if (strikePrice  > data.CE.underlyingValue) { 
                                $(row).find('td:eq(11)').addClass('pe-itm');
                                $(row).find('td:eq(12)').addClass('pe-itm');
                                $(row).find('td:eq(13)').addClass('pe-itm');
                                $(row).find('td:eq(14)').addClass('pe-itm');
                                $(row).find('td:eq(15)').addClass('pe-itm');
                                $(row).find('td:eq(16)').addClass('pe-itm');
                                $(row).find('td:eq(17)').addClass('pe-itm');
                                $(row).find('td:eq(18)').addClass('pe-itm');
                                $(row).find('td:eq(19)').addClass('pe-itm');
                                $(row).find('td:eq(20)').addClass('pe-itm');
                            }


                            $(cells[10]).css('background-color', '#a7dda7')
                            $(cells[21]).css('background-color', '#a7dda7')
                            $(cells[22]).css('background-color', '#a7dda7')
                            $(cells[23]).css('background-color', '#a7dda7')
                        },
                        aoColumns: [    
                            { "defaultContent": '-', 'data': "custom_function",
                                "render": function (custom_function, row, data) { 
                                    var openInterest = data.CE.openInterest; 
                                    return openInterest;
                                }
                            },  
                            { "defaultContent": '-', 'data': "custom_function",
                                "render": function (custom_function, row, data) { 
                                    var changeinOpenInterest = data.CE.changeinOpenInterest; 
                                    return changeinOpenInterest;
                                }
                            },  
                            { "defaultContent": '-', 'data': "custom_function",
                                "render": function (custom_function, row, data) { 
                                    var totalTradedVolume = data.CE.totalTradedVolume; 
                                    return totalTradedVolume;
                                }
                            },  
                            { "defaultContent": '-', 'data': "custom_function",
                                "render": function (custom_function, row, data) { 
                                    var impliedVolatility = data.CE.impliedVolatility; 
                                    return impliedVolatility;
                                }
                            },  
                            { "defaultContent": '-', 'data': "custom_function",
                                "render": function (custom_function, row, data) { 
                                    var lastPrice = data.CE.lastPrice; 
                                    var html = "<span class='text-primary'>"+lastPrice+"</span>";
                                    return html;
                                }
                            },  
                            { "defaultContent": '-', 'data': "custom_function",
                                "render": function (custom_function, row, data) { 
                                    var change = data.CE.change.toFixed(2); 
                                    if(change > 1)
                                        var html = "<span class='text-success'>"+change+"</span>";
                                    else 
                                        var html = "<span class='text-danger'>"+change+"</span>"; 
                                    return html;
                                }
                            },  
                            { "defaultContent": '-', 'data': "custom_function",
                                "render": function (custom_function, row, data) { 
                                    var bidQty = data.CE.bidQty; 
                                    return bidQty;
                                }
                            },  
                            { "defaultContent": '-', 'data': "custom_function",
                                "render": function (custom_function, row, data) { 
                                    var bidprice = data.CE.bidprice; 
                                    return bidprice;
                                }
                            },  
                            { "defaultContent": '-', 'data': "custom_function",
                                "render": function (custom_function, row, data) { 
                                    var askPrice = data.CE.askPrice; 
                                    return askPrice;
                                }
                            },  
                            { "defaultContent": '-', 'data': "custom_function",
                                "render": function (custom_function, row, data) { 
                                    var askQty = data.CE.askQty; 
                                    return askQty;
                                }
                            },  
                            { "defaultContent": '-', 'data': "custom_function",
                                "render": function (custom_function, row, data) { 
                                    var strikePrice = data.strikePrice; 
                                    var html = '<span class="">'+strikePrice+'</span>';
                                    return html;
                                }
                            },  
                            { "defaultContent": '-', 'data': "custom_function",
                                "render": function (custom_function, row, data) { 
                                    var bidQty = data.PE.bidQty; 
                                    return bidQty;
                                }
                            },  
                            { "defaultContent": '-', 'data': "custom_function",
                                "render": function (custom_function, row, data) { 
                                    var bidprice = data.PE.bidprice; 
                                    return bidprice;
                                }
                            },  
                            { "defaultContent": '-', 'data': "custom_function",
                                "render": function (custom_function, row, data) { 
                                    var askPrice = data.PE.askPrice; 
                                    return askPrice;
                                }
                            },  
                            { "defaultContent": '-', 'data': "custom_function",
                                "render": function (custom_function, row, data) { 
                                    var askQty = data.PE.askQty; 
                                    return askQty;
                                }
                            },   
                            { "defaultContent": '-', 'data': "custom_function",
                                "render": function (custom_function, row, data) { 
                                    var change = data.PE.change.toFixed(2); 
                                    if(change > 1)
                                        var html = "<span class='text-success'>"+change+"</span>";
                                    else 
                                        var html = "<span class='text-danger'>"+change+"</span>"; 
                                    return html;
                                }
                            }, 
                            { "defaultContent": '-', 'data': "custom_function",
                                "render": function (custom_function, row, data) { 
                                    var lastPrice = data.PE.lastPrice; 
                                    var html = "<span class='text-primary'>"+lastPrice+"</span>";
                                    return html;
                                }
                            },  
                            { "defaultContent": '-', 'data': "custom_function",
                                "render": function (custom_function, row, data) { 
                                    var impliedVolatility = data.PE.impliedVolatility; 
                                    return impliedVolatility;
                                }
                            },  
                             { "defaultContent": '-', 'data': "custom_function",
                                "render": function (custom_function, row, data) { 
                                    var totalTradedVolume = data.PE.totalTradedVolume; 
                                    return totalTradedVolume;
                                }
                            }, 
                           { "defaultContent": '-', 'data': "custom_function",
                                "render": function (custom_function, row, data) { 
                                    var changeinOpenInterest = data.PE.changeinOpenInterest; 
                                    return changeinOpenInterest;
                                }
                            },  
                            { "defaultContent": '-', 'data': "custom_function",
                                "render": function (custom_function, row, data) { 
                                    var openInterest = data.PE.openInterest; 
                                    return openInterest;
                                }
                            },     
                            { "defaultContent": '-', 'data': "custom_function",
                                "render": function (custom_function, row, data) { 
                                    var CallopenInterest = data.CE.openInterest; 
                                    var PutopenInterest = data.PE.openInterest; 
                                    var pcr = CallopenInterest/PutopenInterest;
                                    pcr= pcr.toFixed(3);
                                    if(pcr < 5)
                                        var html = "<span class='text-black'>"+pcr+"</span>";
                                    else 
                                        var html = "<span class='text-black'>"+pcr+"</span>"; 
                                    return html;
                                }
                            },    
                               
                        ], 
                    });  
                     
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
