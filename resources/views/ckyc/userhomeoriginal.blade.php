@extends('master')
@section('css-section')
<!--link rel="stylesheet" href="{{ asset('Webcam/bootstrap4.1.3.min.css')}}"-->
<!--link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" /-->
<style type="text/css">        
    .my_camera 
    {
        border: 3px solid black;
        width: 320px;
        height: 230px;
        display: inline-block;
        overflow: hidden;
    }
    .results 
    { 
        padding-top: 3px;
        border:1px solid; 
        height:auto;
        width: auto;
        background:#d1d1e0; 
        overflow:auto;
    }

    .results2
    { 
        border:1px solid; 
        background:#ccc; 
    }

    .results3 
    { 
        border:1px solid; 
        background:#ccc; 
    }

    body{background-color: #e1eaea !important;}
    
</style>
@endsection
@section('body-section')
<div style="margin-top:10px">
    @if(session()->has('success'))
        <div class="alert alert-success">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <strong>{{session()->get('success')}}</strong>
        </div>
    @endif
  
    @if(session()->has('failure'))
        <div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <strong>{{session()->get('failure')}}</strong>
        </div>
    @endif
  
    @if(session()->has('warning'))
        <div class="alert alert-warning">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <strong>{{session()->get('warning')}}</strong>
        </div>
    @endif

    @if(session()->has('message'))
        <div class="alert alert-warning">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <strong>{{session()->get('message')}}</strong>
        </div>
    @endif
  </div>
    <div id="ckycdiv">
        <pre><h2 style="text-align: center">C-Kyc Details</h2></pre>
        <div class="alert alert-warning" id="cifwarning" style="display: none">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <strong><span id="stval"></span></strong>
        </div>
                <form method="post" action="storeImageToDB" id="ckycformsubmit">
                    <table class="table table-bordered" style="width: 20%; margin-left: 40%; margin: top: 35%">
                        <tr>
                            <th>CIF</th>
                            <td><input type="text" name='customer_cif' id='customer_cif' style="width: 100%" required onkeypress = "return checkNumber(event)" minlength="11" maxlength="11" minlength="11" autocomplete="off"></td>
                            <!--td><button name="get_options" id='proceed_btn' class="btn btn-info proceed_btn" return false>Proceed</button></td-->
                        </tr>
                    <table>
                    <div class="row">
                        <div class="col-md-3">
                            <div id="my_camera" class="my_camera"></div>
                            <div style="text-align: center">
                                <div class="btn-group" role="group" aria-label="InputButtons">
                                    <input type=button value="Customer Photo" class="btn btn-info" id="sbuttons1"  name="b1" style="float: left" onClick="take_snapshot()">
                                    <input type=button value="Identity Proof" class="btn btn-warning" id="sbuttons2" name="b2"  class="center1" onClick="take_snapshot2()">
                                    <input type=button value="Address Proof" class="btn btn-danger" id="sbuttons3" name="b3" style="float: right" onClick="take_snapshot3()">
                                </div>
                            </div>
                            <!--input type=button value="" onClick="recapture()"-->
                            <input type="hidden" name="image" id="img1" class="image-tag">
                            <input type="hidden" name="image2" id="img2" class="image-tag-2">
                            <input type="hidden" name="image3" id="img3" class="image-tag-3">
                        </div>
                        <div class="col-md-3">
                            <div id="results" class="results" style="text-align: center">Your captured Customer Photo will appear here...<br/>&nbsp;</div>
                        </div>
                        <div class="col-md-3">
                            <div id="results2" class="results" style="text-align: center">Your captured Identity Proof will appear here...<br/>&nbsp;</div>
                        </div>
                        <div class="col-md-3">
                            <div id="results3" class="results" style="text-align: center">Your captured Address Proof will appear here...<br/>&nbsp;</div>
                        </div>
                        <div class="col-md-12 text-center">
                            <br/>
                            <button class="btn btn-success">Submit</button>
                        </div>
                    </div>
                </form>
    </div>
@endsection
@section('js-section')
<!--script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.25/webcam.min.js"></script>-->
<script src="{{ asset('webcam/webcam.min.js')}}"></script>
<script src="{{ asset('webcam/jquery3.3.1.min.js')}}"></script>
    <script>
        Webcam.set({
        width: 1200,
        height: 900,
        image_format: 'jpeg',
        jpeg_quality: 100,
        //force_flash: true
    });
  
    Webcam.attach('#my_camera');
  
    function recapture(){
        document.getElementById('results').innerHTML = 'Your captured image will appear here...';
    }
    function take_snapshot() {
        Webcam.snap( function(data_uri) {
            $(".image-tag").val(data_uri);
            document.getElementById('results').innerHTML = '<img src="'+data_uri+'" height="340" width="440px"/><br/><p style="text-align: center; font-weight: bold; padding-top: 4px">Customer Photo</p>';
        } );
    }
    function take_snapshot2() {
        Webcam.snap( function(data_uri) {
            $(".image-tag-2").val(data_uri);
            document.getElementById('results2').innerHTML = '<img src="'+data_uri+'"height="340px" width="440"/><br/><p style="text-align: center; font-weight: bold;">Proof Of Identity</p>';
        } );
    }
    function take_snapshot3() {
        Webcam.snap( function(data_uri) {
            $(".image-tag-3").val(data_uri);
            document.getElementById('results3').innerHTML = '<img src="'+data_uri+'"height="340px" width="440px"/><br/><p style="text-align: center; font-weight: bold;">Proof of Address</p>';
        } );
    }

        function checkNumber(evt){
		evt = (evt) ? evt : window.event;
		var charCode = (evt.which) ? evt.which : evt.keyCode;
		if (charCode > 31 && (charCode < 48 || charCode > 57)) {
			return false;
		}
		return true;
	}

        $("#customer_cif").focusout(function(){
            $cifno = $('#customer_cif').val();
            $clength = $cifno.length;
            if($clength==11)
            {
                $.ajax(
                        {
                        url: "checkcif/"+$cifno,
                        type: 'get',
                        data: {
                            "id": '1',
                            "_token": 'token',
                            },
                            success: function(results) 
                            {
                                //alert(results['status']);
                                if(results['status']==1)
                                {
                                    //alert('cif already captured');
                                    $('#cifwarning').show();
                                    document.getElementById('stval').innerHTML = 'CIF NO. '+$cifno+' is already captured';
                                    
                                }
                            },
                            error: function(xhr, status, error) 
                            {
                                var err = eval("(" + xhr.responseText + ")");
                                alert(err.Message);
                                console.log(results['status']);    
                            }
                        });
            }                 
        });

        $('#ckycdiv').on('click','.proceed_btn',function(){
            md = $('#customer_cif').val().length;
            if(md<11)
            {
                alert('The Length of cif must be 11 characters.');
                return;
            }
            if(md==11)
            {
                alert('Valid Characters entered');
                return;
            }
            else
            {
                alert('Invalid Input');
                return;
            }
            
        });



        $('#ckycformsubmit').submit(function(){
            if($('#img1').val()=='' || $('#img2').val()=='' || $('#img3').val()=='')
            {
                alert('Images fields cannot be empty');
                return false;
            }
            else
            {
                /*$cifno = $('#customer_cif');
                if($cifno.val().length==11)
                {
                    alert('iam in length match');
                    $.ajax(
                        {
                        url: "checkcif/"+$cifno,
                        type: 'get',
                        data: {
                            "id": '1',
                            "_token": 'token',
                            },
                            success: function(results) 
                            {
                                alert(results['status']);
                                console.log(results['status']);   
                                $md = confirm(results['status']+"Do you want to update ?");
                                if($md){
                                    return true; 
                                }
                                else{
                                    return false;
                                }
                                
                            },
                            error: function(xhr, status, error) 
                            {
                                var err = eval("(" + xhr.responseText + ")");
                                alert(err.Message);
                                console.log(results['status']);    
                            }
                        });
                }*/

                return true;                
            }
        });
    </script>
@endsection