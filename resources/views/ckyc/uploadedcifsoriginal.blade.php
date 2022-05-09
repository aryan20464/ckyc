@extends('master')
@section('css-section')
    <style>
        table.sortable th:not(.sorttable_sorted):not(.sorttable_sorted_reverse):not(.sorttable_nosort):after { 
        content: "\25B4" 
    }
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
    <div class="container-fluid">
        <pre style="text-align: center"><h3>Download C-KYC Data</h3></pre>
        <div class="row">
            <div class="col-md-5">
                <pre><h4 style="text-align: center">DateWise CIF Downloads</h4></pre>
                <table class="table table-bordered sortable" id="">
                    <thead>
                        <tr>
                            <th>S.No</th>
                            <th>Date</th>
                            @isset($ucount)
                            <th>Count</th>
                            @endif
                            <th>Operations</th>
                        </tr>
                    </thead>
                    <tbody>
                        @isset($userdates)
                        @foreach($userdates as $key=>$value)
                        <tr>
                            <td>{{ $loop->index+1 }}</td>
                            <td>{{ date('d-m-Y',strtotime($userdates[$key])) }}</td>
                            @isset($ucount)
                            <td>{{ $ucount[$userdates[$key]] }}</td>
                            @endif
                            <td><a href="{{ url('/downloadfile2/'.$userdates[$key]) }}" class="btn btn-info btn-sm">Download</a></td>
                        </tr>
                        @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
            <div class="col-md-7">
                <pre><h4 style="text-align: center">Individual CIF Downloads</h4></pre>
                <table class="table table-bordered sortable" id="uploadedciftable">
                    <thead>
                        <th>S.No</th>
                        <th>CIF Number</th>
                        <th>Date Uploaded</th>
                        <th>Operations</th>
                    </thead>
                    @isset($userpresent)
                    @foreach($userpresent as $key=>$value)
                    <tr>
                        <td>{{ $loop->index+1 }}</td>
                        <td>{{ $userpresent[$key]->cifnumber }}</td>
                        <td>{{ date('d-m-Y',strtotime($userpresent[$key]->cifdate)) }}</td>
                        <td><a href="{{ url('/download/'.$userpresent[$key]->id) }}" class="btn btn-info btn-sm">Download</a><br/><!--a href="{{ url('/downloadfile2') }}" class="btn btn-info">Download-E</a--></td>
                    </tr>
                    @endforeach
                    @endif
                </table>
            </div>
        </div>
    </div>
@endsection
@section('js-section')
<script type="text/javascript" src="{{ asset('SortTable/sortable.js') }}"></script>
@endsection