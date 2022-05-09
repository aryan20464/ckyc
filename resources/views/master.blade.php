@inject('request', 'Illuminate\Http\Request')
<!DOCTYPE Html>
<html>
<head>
<title>C-Kyc Portal</title>
<meta charset="utf-8"/>
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
<link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
<!--link rel="stylesheet"  href="{{ asset('css/bootstrap.min.css') }}"-->
<link rel="stylesheet"  href="{{ asset('bstrap/bstrap4.4.1.min.css') }}">

<!--link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/css/bootstrap.min.css"/-->
<style type="text/css">
    h5 {
     margin-bottom: 0;
    } 
    .flex-container{
        margin-left:0px;
        margin-right:0px;
        display: flex; /* Standard syntax */
    }
    .body-container{
        margin-left:0px;
        margin-right:0px;
        border:0px solid black;
        padding:15px;
    }
    .flex-container .column{
        background:#00838f;
        color:white;
        flex: 1; /* Standard syntax */
    }
    .topnav {
        margin-left:0px;
        margin-right:0px;
        overflow: hidden;
        background: #00838f;
        border-top:0.5px solid white;
    }
    .topnav-right {
        float: right;
    }
    .topnav a {
        float: left;
        color: #f2f2f2;
        text-align: center;
        padding: 5px 10px;
        text-decoration: none;
        font-size: 15px;
    }
    .topnav a:hover {
        background-color: #ddd;
        color: black;
    }
    .topnav a.active {
        background-color: #4CAF50;
        color: white;
    }
    .alert{padding:5px;margin-bottom:5px;border:1px solid transparent;border-radius:4px}
    .alert-danger{color:#a94442;background-color:#f2dede;border-color:#ebccd1}
    .alert-success{color:#3c763d;background-color:#dff0d8;border-color:#d6e9c6}

    .dropdownmenu {   float: left;   overflow: hidden; }

    .dropdownmenu .dropbtn { 
        font-size: 16px;  
        border: none;
        outline: none;
        color: white;
        padding: 5px 10px;
        background: #00838f;
        font-family: inherit;
        margin: 0;
    }
    .dropdownmenu:hover .dropbtn {
        background-color: #ddd;
        color: black;
    }
    .dropdown-content {
        display: none;
        position: absolute;
        background-color: #f9f9f9;
        min-width: 75px;
        box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
        z-index: 1;
    }
    .dropdown-content a {
        float: none;
        color: black;
        padding: 10px 10px;
        text-decoration: none;
        display: block;
        text-align: left;
    }
    .dropdown-content a:hover {
        background-color: #ddd;
    }
    .dropdownmenu:hover .dropdown-content {
        display: block;
    }
    body {
    color: #333;
    font-family: Arial, Helvetica, sans-serif;
    background:#fff;
    }
    table{font-size:14px;}

    </style>  
    @yield('css-section') 
</head>
<body>
    <div class="flex-container" style="border:1px solid black;">
        <div class="column" style="float:left;">
            <img  src="{{ asset('images/apgvblogo.jpeg') }}" height="40" width="150"/>
        </div>
        <div class="column">
            <div style="text-align:left;height:0px;"><strong>Andhra Pradesh Grameena Vikas Bank <br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;C-KYC Portal</strong></div>
        </div>   
    </div> 
    @section('nav-section')    
        <div class="topnav">
            <div class="topnav-left"> 
                {{-- @if(Config('bcode')==9909)              
                    <a style="border-right:1px solid #FFF;font-size:14px;" href="{{route('home')}}">Home</a>
                     <a style="border-right:1px solid #FFF;font-size:14px;" href="{{route('showUploadedCifs')}}">Downloads</a> }}
                @endif --}}
                {{-- <a style="border-right:1px solid #FFF;font-size:14px;" href="{{route('show_user_data')}}">CKYC Branch</a> --}}
                <a style="border-right:1px solid #FFF;font-size:14px;" href="{{route('emp_summary')}}">CKYC Employee Summary</a> 
            </div>
            <div class="topnav-right">
                <a style="border-right:1px solid #FFF;font-size:14px;">Welcome  {{ Session::get('employee_name') }}</a> 
                <a href="{{route('logout')}}">Logout</a>                
            </div>
        </div>		
    @show 
    <div class="body-container">
        @yield('body-section') 
    </div>
    <!--script type="text/javascript" src="{{ asset('js/jquery-1.11.3.min.js') }}"></!--script-->
    <script src="{{ asset('webcam/jquery3.3.1.min.js')}}"></script>
    <script src="{{ asset('bstrap/bstrap4.4.1.min.js')}}"></--script>
    <!--script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/js/bootstrap.min.js"></!--script-->
    <script>
        $(document).ready(function(){
        $(".nav-tabs a").click(function(){
          $(this).tab('show');
        });
        $('.nav-tabs a').on('shown.bs.tab', function(event){
          var x = $(event.target).text();         // active tab
          var y = $(event.relatedTarget).text();  // previous tab
          $(".act span").text(x);
          $(".prev span").text(y);
        });
    });
    </script>
    @yield('js-section')
</body>
</html>