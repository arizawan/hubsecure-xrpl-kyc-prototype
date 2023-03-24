@extends('layout')
@section('pagespecificstyles')

    <!-- flot charts css-->
    <link rel="stylesheet" href="{{ asset('css/datatables/dataTables.bootstrap4.min.css') }}">

@stop


@section('title','Download KYC')
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

                <!-- Page Heading -->
                <div class="body-heading text-center">
                    <h1>KYC Doc List</h1>
                    <p>Check your KYC Documents</p>
                </div>

                <div class="col-lg-12 mb-8">
                  <!-- Page Heading -->

                  <div class="text-center">
                    <img src="{{ asset('img/list-id.svg') }}" class="img-fluid"
                      width="300px" alt="document-list">
                  </div>
                  <!-- DataTales Example -->
                  <div class="card hub-card-list mb-4 mt-5">

                      <div class="card-body">
                          <div class="table-responsive">
                              <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                  <thead>
                                      <tr>
                                          
                                          <th>Uploaded Date</th>
                                          <th>ID Number</th>
                                          <th>Name</th>
                                          <th>DOB</th>
                                          <th>Live Photo</th>
                                          <th>NFT Status</th>
                                          <th>Status</th>
                                          <th>Action</th>
                                      </tr>
                                  </thead>

                                  <tbody>
                                    @foreach ($data as $docs)
                                        <tr>
                                            <td>{{$docs->created_at}}</td>
                                            <td>{{$docs->cust_id_number}}</td>
                                            <td>{{$docs->name}}</td>
                                            <td>{{$docs->cust_dob}}</td>
                                            @php
                                             $infoPath = pathinfo(public_path($docs->live_photo));
                                            @endphp

                                            <td><img src="{{asset("storage/".$infoPath["basename"])}}" alt="Image" width="120"/></td>
                                            <td>{{$docs->status}}</td>
                                            <td>{{$docs->status}}</td>
                                            <td><a href="/status/check/{{$docs->block_uuid}}" type="submit" class="btn btn-color w-100">Recheck</a></td>
  
                                        </tr>
                                    @endforeach
                                      

                                  </tbody>
                              </table>
                          </div>
                      </div>
                  </div>
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


@endsection
@section('pagespecificscripts')
    <!-- flot charts scripts-->
    <script src="{{ asset('js/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('js/datatables/dataTables.bootstrap4.min.js') }}"></script>
@stop
