@extends('master')
@section('css-section')
    <!--link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.6/cropper.css" /-->
    <link rel="stylesheet"  href="{{ asset('cropper/cropper1.5.6.css') }}">
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
      
      .results 
          { 
              padding: 3px;
              border:1px solid; 
              height:auto;
              width: 540px;
              background:#d1d1e0; 
              overflow:auto;
          }  

          .results-photo 
          { 
              padding: 3px;
              border:1px solid; 
              height:auto;
              width: 400px;
              background:#d1d1e0; 
              overflow:auto;
          }  
              
      
      .modal-lg{
              
      }
      </style>
@endsection
@section('body-section')
<div class="container-fluid">
  <h1>Crop CKYC Images @isset($cifno) pertaining to CIF number :  {{ $cifno }} @endif</h1>
  <input type="hidden" id='cno' @isset($cifno)value="{{ $cifno }}" @endif/>
  <div>        
      <button type="button" id="b1" class="btn btn-info">Customer Photo</button>
      <button type="button" id="b2" class="btn btn-info">Identitiy Proof</button>
      <button type="button" id="b3" class="btn btn-info">Address Proof</button>
  </div>
  <br/>
  <div class="row">
      <div class="col-md-4">
          <div id="results1" class="results-photo" style="text-align: center">Your captured Customer Photo will appear here...<br/>&nbsp;</div>
      </div>
      <div class="col-md-4">
          <div id="results2" class="results" style="text-align: center">Your captured Identity Proof will appear here...<br/>&nbsp;</div>
      </div>
      <div class="col-md-4">
          <div id="results3" class="results" style="text-align: center">Your captured Address Proof will appear here...<br/>&nbsp;</div>
      </div>
  </div>
  <br/>
  <div>
    <form method="post" action="final_submit">
      <input type="hidden" id='cno' name="cifno" @isset($cifno)value="{{ $cifno }}" @endif/>
      <input type="hidden" id='uploaded_date' name="udate" @isset($uploaded) value="{{ $uploaded }}" @endif/>
      <input type="submit" id="fsubmit" style="margin-left: 45%" class="btn btn-info" value="Final Submit"/>
    </form>
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
              <div class="col-md-9">
                  <img id="image1" name='image1' @isset($imageAssets) src="{{ asset($imageAssets[0]) }}" @endif>
              </div>
              <div class="col-md-3">
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
              <div class="col-md-9">
                  <img id="image2" name='image2' @isset($imageAssets) src="{{ asset($imageAssets[1]) }}" @endif>
              </div>
              <div class="col-md-3">
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
              <div class="col-md-9">
                  <img id="image3" name='image3' @isset($imageAssets) src="{{ asset($imageAssets[2]) }}" @endif>
              </div>
              <div class="col-md-3">
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
@endsection
@section('js-section')
    <!--script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.6/cropper.js"></script-->
    <script type="text/javascript" src="{{ asset('cropper/cropper1.5.6.js') }}"></script>
    <script>
      $("#fsubmit").on('click',function(){
        $md = confirm("Are you sure to submit ?");
        if($md)
        {
          return true;
        }
        else{
          return false;
        }
      });
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
          viewMode: 0,
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
          viewMode: 0,
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
          viewMode: 0,
          preview: '.preview2'
          });
      }).on('hidden.bs.modal', function () {
         cropper3.destroy();
         cropper3 = null;
      });
      
      $("#crop1").click(function(){
          canvas = cropper1.getCroppedCanvas({
            width: 340,
            height: 340,
            });
      
          canvas.toBlob(function(blob) {
              url = URL.createObjectURL(blob);
              var reader = new FileReader();
               reader.readAsDataURL(blob); 
               reader.onloadend = function() {
                  var base64data = reader.result;	
                  var cno = $('#cno').val();                  
                  console.log(cno);
                  $.ajax({
                        type: "POST",
                        dataType: "json",
                        url: "image-cropper/upload",
                        data: {'_token': $('meta[name="_token"]').attr('content'), 'image': base64data, 'cif': cno , 'type': 'photo'},
                        //rename type here as photo for overwriting the files to the original files in case crop is done.
                        success: function(data)
                        {
                            $modal.modal('hide');
                            //alert("success upload image");
                            var timestamp = new Date().getTime();
                            var n = "{{ date('Ymd') }}";
                            var x = $('#uploaded_date').val();
                            if(x!=0)
                            {
                              n = x;
                            }
                            var maxval = `{{ asset('uploads/${n}/${cno}/${cno}') }}`;
                            maxval = maxval+"_photo.jpeg";
                            rand = "?t=" + timestamp; 
                            document.getElementById('results1').innerHTML = '<img src='+maxval+rand+' height="340" width="400px"/><br/><p style="text-align: center; font-weight: bold; padding: 10px">Customer Photo</p>';
                        },
                        error: function (request, error) {
                            console.log(arguments);
                            alert(" Error Occurred " + error);
                        },
                    });
               }
          });
      });
      
      $("#crop2").click(function(){
          canvas = cropper2.getCroppedCanvas({
            width: 720,
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
                      data: {'_token': $('meta[name="_token"]').attr('content'), 'image': base64data, 'cif': cno , 'type': 'idproof'},
                       //rename type here as idproof for overwriting the files to the original files in case crop is done.
                      success: function(data){
                          $modal2.modal('hide');
                          //alert("success upload image");
                          var timestamp = new Date().getTime();
                          var n = "{{ date('Ymd') }}";
                          var x = $('#uploaded_date').val();
                          if(x!=0)
                          {
                            n = x;
                          }
                          var maxval = `{{ asset('uploads/${n}/${cno}/${cno}') }}`;
                          maxval = maxval+"_idproof.jpeg";
                          rand = "?t=" + timestamp;  
                          document.getElementById('results2').innerHTML = '<img src='+maxval+rand+' height="340" width="540px"/><br/><p style="text-align: center; font-weight: bold; padding-top: 4px; padding-left: 4px">IDProof</p>';
                      },
                      error: function (request, error) {
                            console.log(arguments);
                            alert(" Error Occurred " + error);
                        },
                    });
               }
          });
      });
      
      $("#crop3").click(function(){
          canvas = cropper3.getCroppedCanvas({
            width: 720,
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
                      data: {'_token': $('meta[name="_token"]').attr('content'), 'image': base64data, 'cif': cno , 'type': 'addr_proof'},
                       //rename type here as addr_proof for overwriting the files to the original files in case crop is done.
                      success: function(data){
                          $modal3.modal('hide');
                          //alert("success upload image");
                          //$('#b3').hide();
                          var timestamp = new Date().getTime();
                          var n = "{{ date('Ymd') }}";
                          var x = $('#uploaded_date').val();
                          if(x!=0)
                          {
                            n = x;
                          }
                          var maxval = `{{ asset('uploads/${n}/${cno}/${cno}') }}`;
                          maxval = maxval+"_addr_proof.jpeg";
                          rand = "?t=" + timestamp;  
                          document.getElementById('results3').innerHTML = '<img src='+maxval+rand+' height="340" width="540px"/><br/><p style="text-align: center; font-weight: bold; padding-top: 4px; padding-left: 4px">Address Proof</p>';
                      },
                      error: function (request, error) {
                            console.log(arguments);
                            alert(" Error Occurred " + error);
                        },
                    });
               }
          });
      });
      
      </script>
@endsection