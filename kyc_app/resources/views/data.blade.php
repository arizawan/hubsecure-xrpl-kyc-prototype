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

                <div class="col-lg-12 mb-8">
                  <!-- Page Heading -->
                  <h1 class="h3 mb-2 text-gray-800">{{$data->name}}</h1>
                  <p class="mb-4">KYC Document status</p>
                  <div class="text-center">
                    <img src="{{ asset('img/docuement-list.svg') }}" class="img-fluid"
                      width="400px" alt="document-list">
                  </div>
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
                  <!-- DataTales Example -->
                  <div class="card shadow mb-4">

                      <div class="card-body">
                          <div class="table-responsive">
                              <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                  <thead>
                                      <tr>
                                          
                                          <th>Uploaded Date</th>
                                          <th>Verification Result</th>
                                          <th>NFT Data</th>
                                          <th>KYC Result</th>
                                          <th>Data</th>
                                          <th>Status</th>
                                          <th>Action</th>
                                      </tr>
                                  </thead>
                                  @php 
                                        $idData = json_decode($data->id_data);
                                        $result = $idData->identity_data->result;
                                        $verification = $idData->identity_data->verification;
                                        $verificationResult = $verification->result;
                                        $blockData = json_decode($data->block_data);
                                    @endphp
                                  <tbody>
                                    <td>{{$data->created_at}}</td>
                                    <td>{{$verification->passed ? "True" : "False"}}</td>
                                    <td>
                                        @if ($blockData && $blockData->status =="compleated")
                                            <ul>
                                            @foreach ($blockData->block_data as $key => $value)
                                            <li>{{ $key }} = {{ $value }} </li>
                                            @endforeach
                                            </ul>
                                        @endif
                                    </td>
                                    <td>
                                        <ul>
                                            @foreach ($verificationResult as $key => $value)
                                             <li>{{ $key }} = {{ $value }} </li>
                                            @endforeach
                                            </ul>
                                    </td>
                                    <td>
                                        <ul>
                                        @foreach ($result as $key => $value)
                                         <li>{{ $key }} = {{ $value }} </li>
                                        @endforeach
                                        </ul>
                                    </td>
                                    <td>{{$data->status}}</td>
                                    <td>
                                        @if ($blockData)
                                            @if ($blockData->status =="compleated")
                                                <a href="#" class="btn w-100">Minted</a>
                                            @else
                                                <a href="/nft/mint/{{$data->block_uuid}}" type="submit" class="btn btn-color w-100">Recheck Mint Status</a>
                                            @endif
                                        @else 
                                            <a href="/nft/mint/{{$data->block_uuid}}" type="submit" class="btn btn-color w-100">Mint NFT</a>
                                        @endif
                                    </td>
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
