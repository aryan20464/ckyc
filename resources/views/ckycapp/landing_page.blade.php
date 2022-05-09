@extends('master')
@section('css-section')
    <link rel="stylesheet" href="{{ asset('css/jquery.dataTables.min.css') }}"/>
    <link rel="stylesheet" href="{{ asset('css/buttons.dataTables.min.css') }}"/>
    <link rel="stylesheet" href="{{ asset('css/buttons.bootstrap4.min.css') }}"/>
@endsection
@section('body-section')
<div class="container-fluid" style="margin-top: 2%">
    <div class="card bg-light">
        <div class="card-header">
          <h4 style="text-align: center">CKYC Uploaded Documents</h4>
        </div>        
           
            <div class="card-body tab-content" id="myTabContent">
                    <table id="example11" class="display wordwrap" style="width:100%">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Empid</th>
                                <th>CIF</th>
                                <!--th>Role</!--th-->
                                <!--th>Bcode</!--th-->
                                <th>Branch</th>
                                <!--th>Region</!--th-->                    
                                <th>Customer Photo</th>
                                <th>Identity-1</th>
                                <th>Identity-2</th>
                                <th>Status</th>
                            </tr>                        
                        </thead>                    
                        @isset($rows)               
                        <tbody>
                            @foreach($rows as $key=>$value)
                                <tr>
                                    <td>{{ $loop->index+1 }}</td>
                                    <td>{{ $rows[$key]->emp_id }}</td>
                                    <td>{{ $rows[$key]->CIF_No }}</td>
                                    <td>{{ $rows[$key]->bcode }}</td>
                                    <td><img src="data:image/png;base64, {{$rows[$key]->img}}"  width="100" height="100" /></td>
                                    <td><img src="data:image/png;base64, {{$rows[$key]->ID1}}"  width="100" height="100" /></td>
                                    <td>@if($rows[$key]->ID2==null)
                                        <img src="data:image/png;base64, {{$rows[$key]->ID2}}"  width="100" height="100" />
                                        @else
                                        Not Uploaded
                                        @endif
                                    </td>
                                    <td><a href="{{ route('get_indi_download',['cifnumber'=>$rows[$key]->CIF_No]) }}" class="btn btn-sm btn-primary">Download</a></td>
                                </tr>
                            @endforeach                                
                        </tbody>       
                        @endisset                           
                    </table>
                    @isset($var_string)
                    <div style="margin-top: 1%">
                        <a href="{{ route('download_all',['vals'=>$var_string]) }}" class="btn btn-primary btn-sm" style="float: right">Download All</a>
                    </div>
                    @endif  
                </div>
            </div>
        </div>
      </div>
    
</div>

@endsection
@section('js-section')
    
        <script type="text/javascript" src="{{ asset('js/jquery-3.5.1.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/dataTables.buttons.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/buttons.bootstrap4.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/jszip.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/pdfmake.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/vfs_fonts.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/buttons.html5.min.js') }}"></script>   
        <script type="text/javascript" src="{{ asset('js/buttons.print.min.js') }}"></script>
        <script>
            $('#example11').DataTable({
            dom: 'Bfrtip',
            paginate: false, // pagination is set to false
            info: false, // to disable all the text such as showing 1 to 8 entries
            //"iDisplayLength": 100, // how many entries to show in the table
            buttons: [
                { extend: 'csv', className: 'btn btn-danger '},
                    { extend: 'excel', className: 'btn btn-info'},
                    { extend: 'pdf', className: 'btn btn-success '},
                    { extend: 'print', className: 'btn btn-warning '}
            ],
            autoWidth: false,
            });

            $('#example12').DataTable({
            dom: 'Bfrtip',
            paginate: false, // pagination is set to false
            info: false, // to disable all the text such as showing 1 to 8 entries
            //"iDisplayLength": 100, // how many entries to show in the table
            buttons: [
                { extend: 'csv', className: 'btn btn-danger '},
                    { extend: 'excel', className: 'btn btn-info'},
                    { extend: 'pdf', className: 'btn btn-success '},
                    { extend: 'print', className: 'btn btn-warning '}
            ],
            autoWidth: false,
            });

            $('#example13').DataTable({
            dom: 'Bfrtip',
            paginate: false, // pagination is set to false
            info: false, // to disable all the text such as showing 1 to 8 entries
            //"iDisplayLength": 100, // how many entries to show in the table
            buttons: [
                { extend: 'csv', className: 'btn btn-danger '},
                    { extend: 'excel', className: 'btn btn-info'},
                    { extend: 'pdf', className: 'btn btn-success '},
                    { extend: 'print', className: 'btn btn-warning '}
            ],
            autoWidth: false,
            });

            

            
        </script>
@endsection