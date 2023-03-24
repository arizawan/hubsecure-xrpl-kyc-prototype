@extends('layout')
@section('title','Dashboard')
@section('content')

<!-- Page Wrapper -->
<div id="wrapper">

      @include('include.nav')

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

        <!-- Main Content -->
        <div id="content">

            <!-- Topbar -->

                @include('include.topbar')
            <!-- End of Topbar -->

            <!-- Begin Page Content -->
            <div class="container-fluid main-page">
                
                <div class="body-heading text-center">
                    <h1>Upload Documents</h1>
                    <div class="head-icon">
                        <img src="{{ asset('img/upload.svg') }}" class="img-fluid">
                    </div>     
                </div>

                <div class="kyc-form-wrap">

                    <div class="mt-5">
                        @if($errors->any())
                          <div class="col-12">
                            @foreach($errors->all() as $error)
                              <div class="alert alert-danger">{{$error}}</div>
                            @endforeach
                          </div>
                        @endif
              
                        @if(session()->has('error'))
                          <div class="alert alert-danger">{{session('error')}}</div>
                        @endif
                          
                        @if(session()->has('success'))
                          <div class="alert alert-success">{{session('success')}}</div>
                        @endif
                    </div>

                    @if(session()->has('success'))
                        <div></div>
                    @else
                    <div class="card kyc-card my-8">

                        <form class="card-body" action="/kyc/upload" id="kyc-upload" method="post" enctype="multipart/form-data">
                          @csrf <!-- {{ csrf_field() }} -->
                          
                            <div class="row">
                              <div class="form-item col-md-12">
                                  <label for="document_type">Select Document Type:</label>
                                  <select name="document_type" class="form-control form-select">
                                      <option value="id-card">ID card</option>
                                      <option value="driving-license">Driving License</option>
                                      <option value="passport">Passport</option>
                                  </select>
                              </div>
      
                              <div class="form-item col-md-6">
                                  <label for="cust_id_number">ID Number:</label>
                                  <input type="text" id="cust_id_number" class="form-control" name="cust_id_number" placeholder="XXXXXX">
                              </div>
      
                              <div class="form-item col-md-6">
                                  <label for="cust_dob">Date Of Birth:</label>
                                  <input type="text" id="cust_dob" class="form-control" name="cust_dob" placeholder="YYYY/MM/DD">
                              </div>
      
                              <div class="form-item col-md-6">
                                <label for="doc_front">Document Front Page:</label>
                                <input type="file" id="doc_front" class="form-control-file" name="doc_front">
                              </div>
      
                              <div class="form-item col-md-6">
                                  <label for="doc_back">Document Back Page:</label>
                                  <input type="file" id="doc_back" class="form-control-file" name="doc_back">
                              </div>
      
                              <div class="form-item col-md-12">
                                  <label for="video">Capture Live Photo:</label>
                                  <video id="video" width="640" height="480" autoplay style="display:none;"></video>
                                  <canvas id="canvas" width="640" height="480" style="display:none;"></canvas>
                                  <button id="start-camera" class="form-control">Start Camera</button>
                                  <button id="click-photo" class="form-control" style="display:none;">Click Photo</button>
                                  <input id="live_photo" name="live_photo" type="hidden" value=""/>
                              </div>
  
                            </div>
                          <div class="content-footer text-center">
                            <button type="submit" class="btn btn-dark">Upload</button>
                        </div>
                          
                        </form>
                      </div>
                    @endif
                    
                </div>


            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- End of Main Content -->

        <!-- Footer -->
        @include('include.footer')
        <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

</div>
<!-- End of Page Wrapper -->

<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>

<!-- Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <a class="btn btn-primary" href="{{route('logout')}}">Logout</a>
            </div>
        </div>
    </div>
</div>

<script>
    let camera_button = document.querySelector("#start-camera");
    let video = document.querySelector("#video");
    let click_button = document.querySelector("#click-photo");
    let canvas = document.querySelector("#canvas");

    camera_button.addEventListener('click', async function(e) {
        e.preventDefault();
        let stream = await navigator.mediaDevices.getUserMedia({ video: true, audio: false });
        video.srcObject = stream;
        $("#canvas").hide();
        $("#video").show();
        $("#start-camera").hide();
        $("#click-photo").show();
    });

    click_button.addEventListener('click', function(e) {
        e.preventDefault();
        canvas.getContext('2d').drawImage(video, 0, 0, 640, 480);
        let image_data_url = canvas.toDataURL('image/jpeg');
        $("#live_photo").val(image_data_url);
        $("#video").hide();
        $("#start-camera").show();
        $("#click-photo").hide();
        $("#canvas").show();
        // data url of the image
        //console.log(image_data_url);
    });
</script>
@endsection
