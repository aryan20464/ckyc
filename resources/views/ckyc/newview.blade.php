<html>
<head>
    <style>
    /* CSS comes here */
    #video {
        border: 1px solid black;
        width: 320px;
        height: 240px;
    }

    #photo {
        border: 1px solid black;
        width: 320px;
        height: 240px;
    }

    #canvas {
        display: none;
    }

    .camera {
        width: 340px;
        display: inline-block;
    }

    .output {
        width: 340px;
        display: inline-block;
    }

    .startbutton {
        display: block;
        position: relative;
        margin-left: auto;
        margin-right: auto;
        bottom: 36px;
        padding: 5px;
        background-color: #6a67ce;
        border: 1px solid rgba(255, 255, 255, 0.7);
        font-size: 14px;
        color: rgba(255, 255, 255, 1.0);
        cursor: pointer;
    }

    .contentarea {
        font-size: 16px;
        font-family: Arial;
    }
    </style>
</head>
<body>
    <div class="contentarea">
        <h1>
            Using Javascript to capture Photo
        </h1>
        <div class="row">
            <div class="col-md-3">
                <div class="camera">
                    <video id="video">Video stream not available.</video>
                </div>
                <div>                    
                    <input type=button value="Customer Photo" id="startbutton"  name="b1" onClick="take_snapshot()">
                    <input type=button value="Identity Proof" id="sbuttons2" name="b2" class="center1" onClick="take_snapshot2()">
                    <input type=button value="Address Proof" id="sbuttons3" name="b3"  onClick="take_snapshot3()">
                </div>
                <canvas id="canvas"></canvas>
            </div>
            <div class="col-md-3">
                <div id="results" class="results" style="text-align: center">Your captured Customer Photo will appear here...<br/>&nbsp;</div>
            </div>
            <div class="col-md-3">
                <div id="results2" style="text-align: center">Your captured Identity Proof will appear here...</div>
            </div>
            <div class="col-md-3">
                <div id="results3" style="text-align: center">Your captured Address Proof will appear here...</div>
            </div>
        
        <div class="output">
            <img id="photo" alt="The screen capture will appear in this box.">
        </div>
    </div>
    <script src="{{ asset('webcam/webcam.min.js')}}"></script>
<script src="{{ asset('webcam/jquery3.3.1.min.js')}}"></script>
    <script>
        /* JS comes here */
        (function() {
    
            var width = 320; // We will scale the photo width to this
            var height = 0; // This will be computed based on the input stream
    
            var streaming = false;
    
            var video = null;
            var canvas = null;
            var photo = null;
            var startbutton = null;
    
            function startup() {
                video = document.getElementById('video');
                canvas = document.getElementById('canvas');
                photo = document.getElementById('photo');
                startbutton = document.getElementById('startbutton');
    
                navigator.mediaDevices.getUserMedia({
                        video: true,
                        audio: false
                    })
                    .then(function(stream) {
                        video.srcObject = stream;
                        video.play();
                    })
                    .catch(function(err) {
                        console.log("An error occurred: " + err);
                    });
    
                video.addEventListener('canplay', function(ev) {
                    if (!streaming) {
                        height = video.videoHeight / (video.videoWidth / width);
    
                        if (isNaN(height)) {
                            height = width / (4 / 3);
                        }
    
                        video.setAttribute('width', width);
                        video.setAttribute('height', height);
                        canvas.setAttribute('width', width);
                        canvas.setAttribute('height', height);
                        streaming = true;
                    }
                }, false);
    
                startbutton.addEventListener('click', function(ev) {
                    takepicture();
                    ev.preventDefault();
                }, false);
    
                clearphoto();
            }
    
    
            function clearphoto() {
                var context = canvas.getContext('2d');
                context.fillStyle = "#AAA";
                context.fillRect(0, 0, canvas.width, canvas.height);
    
                var data = canvas.toDataURL('image/png');
                photo.setAttribute('src', data);
            }
    
            function takepicture() {
                var context = canvas.getContext('2d');
                if (width && height) {
                    canvas.width = width;
                    canvas.height = height;
                    context.drawImage(video, 0, 0, width, height);
    
                    var data = canvas.toDataURL('image/png');
                    photo.setAttribute('src', data);
                } else {
                    clearphoto();
                }
            }
    
            window.addEventListener('load', startup, false);
        })();

        function take_snapshot() {
        Webcam.snap( function(data_uri) {
            $(".image-tag").val(data_uri);
            document.getElementById('results').innerHTML = '<img src="'+data_uri+'"/><br/><p style="text-align: center;">Customer Photo</p>';
        } );
    }
    function take_snapshot2() {
        Webcam.snap( function(data_uri) {
            $(".image-tag-2").val(data_uri);
            document.getElementById('results2').innerHTML = '<img src="'+data_uri+'"/><br/><p style="text-align: center">Proof Of Identity</p>';
        } );
    }
    function take_snapshot3() {
        Webcam.snap( function(data_uri) {
            $(".image-tag-3").val(data_uri);
            document.getElementById('results3').innerHTML = '<img src="'+data_uri+'"/><br/><p style="text-align: center">Proof of Address</p>';
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
            else{
                return true;
            }
        });
        </script>
</body>
</html>