@extends('master')
@section('css-section')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.6/cropper.css" integrity="sha256-jKV9n9bkk/CTP8zbtEtnKaKf+ehRovOYeKoyfthwbC8=" crossorigin="anonymous" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha256-WqU1JavFxSAMcLP2WIOI+GB2zWmShMI82mTpLDcqFUg=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.js" integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.6/cropper.js" integrity="sha256-CgvH7sz3tHhkiVKh05kSUgG97YtzYNnWt6OXcmYzqHY=" crossorigin="anonymous"></script>
    <script src="{{ asset('webcam/webcam.min.js')}}"></script>
<style type="text/css">
    img {
        display: block;
        max-width: 100%;
    }
    .preview, .preview1, .preview2 {
        overflow: hidden;
        width: 160px; 
        height: 160px;
        margin: 10px;
        border: 1px solid red;
    }

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


.modal-lg{
  max-width: 1000px !important;
}
</style>
@endsection
@section('body-section')
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
                        <input type=button value="Customer Photo" id="sbuttons1"  name="b1" style="float: left" onClick="take_snapshot()">
                        <input type=button value="Identity Proof" id="sbuttons2" name="b2"  class="center1" onClick="take_snapshot2()">
                        <input type=button value="Address Proof" id="sbuttons3" name="b3" style="float: right" onClick="take_snapshot3()">
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
<div class="container">
    <h1>Crop CKYC Images</h1>
    <input type="hidden" id='cno' @isset($cifno)value="{{ $cifno }}" @endif/>
    <div>        
        <button type="button" id="b1" class="btn btn-info">Photo-1</button>
        <button type="button" id="b2" class="btn btn-info">Photo-2</button>
        <button type="button" id="b3" class="btn btn-info">Photo-3</button>
    </div>
    <br/>
    <div class="row">
        <div class="col-md-4">
            <div id="results" class="results" style="text-align: center">Your captured Customer Photo will appear here...<br/>&nbsp;</div>
        </div>
        <div class="col-md-4">
            <div id="results2" class="results" style="text-align: center">Your captured Identity Proof will appear here...<br/>&nbsp;</div>
        </div>
        <div class="col-md-4">
            <div id="results3" class="results" style="text-align: center">Your captured Address Proof will appear here...<br/>&nbsp;</div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal1" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalLabel">Customer Photo</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="img-container">
            <div class="row">
                <div class="col-md-8">
                    <img id="image1" name='image1' @isset($imageAssets) src="{{ asset($imageAssets[0]) }}" @endif>
                </div>
                <div class="col-md-4">
                    <div class="preview"></div>
                </div>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary" id="crop1">Crop</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modal2" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalLabel">Identity Proof</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="img-container">
            <div class="row">
                <div class="col-md-8">
                    <img id="image2" name='image2' @isset($imageAssets) src="{{ asset($imageAssets[1]) }}" @endif>
                </div>
                <div class="col-md-4">
                    <div class="preview1"></div>
                </div>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary" id="crop2">Crop</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modal3" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalLabel">Address Proof</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="img-container">
            <div class="row">
                <div class="col-md-8">
                    <img id="image3" name='image3' @isset($imageAssets) src="{{ asset($imageAssets[2]) }}" @endif>
                </div>
                <div class="col-md-4">
                    <div class="preview2"></div>
                </div>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary" id="crop3">Crop</button>
      </div>
    </div>
  </div>
</div>

</div>
</div>

@endsection
@section('js-section')
<script>
var $modal = $('#modal1');
var image1 = document.getElementById('image1');
var $modal2 = $('#modal2');
var image2 = document.getElementById('image2');
var $modal3 = $('#modal3');
var image3 = document.getElementById('image3');
var cropper1;
var cropper2;
var cropper3;
  
$('#b1').on('click',function(){
    $('#modal1').modal('show');

});

$('#b2').on('click',function(){
    $('#modal2').modal('show');

});

$('#b3').on('click',function(){
    $('#modal3').modal('show');

});

//modal1
$modal.on('shown.bs.modal', function () {
    cropper1 = new Cropper(image1, {
	  //aspectRatio: 1,
	  viewMode: 3,
	  preview: '.preview'
    });
}).on('hidden.bs.modal', function () {
   cropper1.destroy();
   cropper1 = null;
});

//modal2
$modal2.on('shown.bs.modal', function () {
    cropper2 = new Cropper(image2, {
	  //aspectRatio: 1,
	  viewMode: 3,
	  preview: '.preview1'
    });
}).on('hidden.bs.modal', function () {
   cropper2.destroy();
   cropper2 = null;
});

//modal3
$modal3.on('shown.bs.modal', function () {
    cropper3 = new Cropper(image3, {
	  //aspectRatio: 1,
	  viewMode: 3,
	  preview: '.preview2'
    });
}).on('hidden.bs.modal', function () {
   cropper3.destroy();
   cropper3 = null;
});

$("#crop1").click(function(){
    canvas = cropper1.getCroppedCanvas({
	    width: 480,
	    height: 720,
      });

    canvas.toBlob(function(blob) {
        url = URL.createObjectURL(blob);
        var reader = new FileReader();
         reader.readAsDataURL(blob); 
         reader.onloadend = function() {
            var base64data = reader.result;	
            var cno = $('#cno').val();
            $.ajax({
                type: "POST",
                dataType: "json",
                url: "image-cropper/upload",
                data: {'_token': $('meta[name="_token"]').attr('content'), 'image': base64data, 'cif': cno , 'type': 'crop1'},
                success: function(data){
                    $modal.modal('hide');
                    alert("success upload image");
                    //$('#b1').hide();
                    var dt = "D:\\Server\\data\\htdocs\\ckyc\\public\\";
                    document.getElementById('results').innerHTML = '<img src='+"{{ asset('44444342343_crop1.jpeg') }}"+' height="340" width="440px"/><br/><p style="text-align: center; font-weight: bold; padding-top: 4px">Customer Photo</p>';
                }
              });
         }
    });
});

$("#crop2").click(function(){
    canvas = cropper2.getCroppedCanvas({
	    width: 480,
	    height: 720,
      });

    canvas.toBlob(function(blob) {
        url = URL.createObjectURL(blob);
        var reader = new FileReader();
         reader.readAsDataURL(blob); 
         reader.onloadend = function() {
            var base64data = reader.result;	
            var cno = $('#cno').val();
            $.ajax({
                type: "POST",
                dataType: "json",
                url: "image-cropper/upload",
                data: {'_token': $('meta[name="_token"]').attr('content'), 'image': base64data, 'cif': cno , 'type': 'crop2'},
                success: function(data){
                    $modal2.modal('hide');
                    alert("success upload image");
                    //$('#b2').hide();
                }
              });
         }
    });
});

$("#crop3").click(function(){
    canvas = cropper3.getCroppedCanvas({
	    width: 480,
	    height: 720,
      });

    canvas.toBlob(function(blob) {
        url = URL.createObjectURL(blob);
        var reader = new FileReader();
         reader.readAsDataURL(blob); 
         reader.onloadend = function() {
            var base64data = reader.result;	
            var cno = $('#cno').val();
            $.ajax({
                type: "POST",
                dataType: "json",
                url: "image-cropper/upload",
                data: {'_token': $('meta[name="_token"]').attr('content'), 'image': base64data, 'cif': cno , 'type': 'crop3'},
                success: function(data){
                    $modal3.modal('hide');
                    alert("success upload image");
                    //$('#b3').hide();
                }
              });
         }
    });
});

Webcam.set({
        width: 450,
        height: 340,
        image_format: 'jpeg',
        jpeg_quality: 100
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