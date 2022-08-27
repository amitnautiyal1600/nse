<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>@yield('title')</title> 

        <!-- Styles -->  
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="//cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css" rel="stylesheet">
        <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.css"/>
        <!-- Styles End-->  

        <!-- Scripts --> 
        <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.js"></script>
        <script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js"></script> 
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
        <!-- Scripts End--> 
        <style type="text/css">
            .index-cell{
                background: darkred !important; 
                color: white !important; 

            }
            .body {
                font-size: 13px;
                font-family: sans-serif;
            }
            .dynamic_data_red {
                font-weight: 900;
                color: darkred;
            }
            .dynamic_data_green {
                font-weight: 900;
                color: green;
            }
            .ce-itm, .pe-itm {
                background: #faf3cd !important;
            }
            .row_selected {
                /*background: purple !important;*/
                border-bottom: 20px solid darkred;
                font-weight: 900;
                color: darkred;
            }
        </style> 
    </head>
    <body class="body">
        <main>
          <header class="p-3 text-bg-dark">
                <div class="container">
                  <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
                    <a href="/" class="d-flex align-items-center mb-2 mb-lg-0 text-white text-decoration-none">
                      <svg class="bi me-2" width="40" height="32" role="img" aria-label="Bootstrap"><use xlink:href="#bootstrap"></use></svg>
                    </a>

                    <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
                      <li><a href="{{route('niftyHome')}}" class="nav-link px-2 text-secondary">Nifty</a></li>
                      <li><a href="{{route('bankNiftyHome')}}" class="nav-link px-2 text-white">Bank Nifty</a></li> 
                      <li><a href="{{route('chartHome')}}" class="nav-link px-2 text-white">Charts</a></li> 
                    </ul>

                    <div class="justify-content-center" id="pageloading" style="display:none">
                        <div class="spinner-border" role="status">
                          <span class="sr-only">Loading...</span>
                        </div>
                        <div class="spinner-grow" role="status">
                          <span class="sr-only">Loading...</span>
                        </div>
                    </div> 

                    <div class="text-end">  
                        <span>Range &nbsp;</span>
                    </div>
                    <div class="text-end" style="padding-right: 6px;">  
                        <select name="row_range" class="form-select form-select-sm row_range">
                            <option value="400" selected>400</option>
                            <option value="800">800</option>
                            <option value="1200">1200</option>
                            <option value="50000">All</option>
                        </select>
                    </div>
                    <div class="text-end"> 
                      <button type="button" class="btn btn-warning refresh_nse_data">
                          <i class="fa fa-refresh"></i> Refresh
                      </button>
                    </div>
                  </div>
                </div>
          </header>
          @yield('content')
      </main> 
    </body>
    <script type="text/javascript"> 
        var oiChartObj;
        var oiBarChartObj;
        $( document ).ready(function() { 

            toastr.options.positionClass = 'toast-bottom-left'; 

            setInterval(function() {
                var today = new Date();  
                if(today.getHours() > 9 && today.getHours() < 16){
                   save_nifty_nse_data();
                   save_bank_nifty_nse_data();
                }
            }, 60 * 2 * 1000); // in every 2 minutes 

        }); 

        function save_nifty_nse_data() {
            var ajaxUrl = "save-nifty-nse-data";
            var index = 0;
            $.ajax({
                type: "GET",
                url: ajaxUrl,
                timeout: 40000, 
                dataType: 'json',
                beforeSend: function(response)
                {
                    //$('#pageloading').show();
                },
                success: function(response)
                { 
                    //toastr.success('NSE data saved successfully!!'); 
                },
                error: function(response) {
                    toastr.error('Error In saving NSE data.<br/> TRY AGAIN!'); 
                },
                complete: function(response)
                {   
                    //$('#pageloading').hide();  
                }
            }); //Ajax End
        }

         
        function save_bank_nifty_nse_data() {
            var ajaxUrl = "save-bank-nifty-nse-data"; 
            var index = 0;
            $.ajax({
                type: "GET",
                url: ajaxUrl,
                timeout: 40000, 
                dataType: 'json',
                beforeSend: function(response)
                {
                    //$('#pageloading').show();
                },
                success: function(response)
                { 
                    //toastr.success('NSE data saved successfully!!'); 
                },
                error: function(response) {
                    toastr.error('Error In saving NSE data.<br/> TRY AGAIN!'); 
                },
                complete: function(response)
                {   
                    //$('#pageloading').hide();  
                }
            }); //Ajax End
        }  
    </script> 
</html>
