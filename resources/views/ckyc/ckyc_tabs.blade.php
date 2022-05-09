@extends('master')
@section('body-section')
<body>
    <div class="container-fluid">
      
      <ul class="nav nav-tabs" id="myLinks">
        <li class="active"><a data-toggle="tab" href="#home">Scan</a></li>
        <li><a  href="#menu1" data-toggle="tab">Crop</a></li>
      </ul>

        <div class="tab-content" id="myTabs">
            <div id="home" class="tab-pane fade in active">
            @include('ckyc.userhometab')
            </div>
            <div id="menu1" class="tab-pane fade">
            @include('ckyc.usercroptab')
            </div>
        </div>
    </div>
@endsection
@section('js-section')
    <script>
      $("#myTabs form").on('submit',function(e) {
      e.preventDefault();
      var li_count = $('.nav-tabs li').length;
      var current_active = $('.nav-tabs li.active').index();
      if(current_active<li_count){
        $('.nav-tabs li.active').next('li').find('a').attr('data-toggle','tab').tab('show');
      }else{
        alert('Last Step');
      }
    });

    </script>
@endsection