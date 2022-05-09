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
                                <th>Employee</th>
                                <th>CIF</th>
                                <th>Bcode</th>
                                <th>Branch</th>
                                <th>Status</th>
                            </tr>                        
                        </thead>                    
                        @isset($rows)               
                        <tbody>
                            @foreach($rows as $key=>$value)
                                <tr>
                                    <td>{{ $loop->index+1 }}</td>
                                    <td>{{ $rows[$key]->emp_id }}</td>
                                    <td>@isset($emps[$rows[$key]->emp_id]){{ $emps[$rows[$key]->emp_id] }} @else notavail @endisset</td>
                                    <td>{{ $rows[$key]->CIF_No }}</td>
                                    <td>{{ $rows[$key]->bcode }}</td>
                                    <td>@isset($branches[$rows[$key]->bcode]){{ $branches[$rows[$key]->bcode] }} @else notavail @endisset</td>
                                    <td>{{ $rows[$key]->updated_at }}</td>
                                </tr>
                            @endforeach                                
                        </tbody>       
                        @endisset                           
                    </table>  
                
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
                "scrollY": "450px",
                "scrollCollapse": true,
                "paging": false,
                //"iDisplayLength": 15, // how many entries to show in the table
                buttons: [
                        /*{ extend: 'csv', className: 'btn btn-danger '},                    
                        { extend: 'pdf', className: 'btn btn-success '},
                        { extend: 'print', className: 'btn btn-warning '}*/
                        { extend: 'excel', className: 'btn btn-info'},
                ],
                autoWidth: false,
            });

            $('#example12').DataTable({
                dom: 'Bfrtip',
                paginate: false, // pagination is set to false
                info: false, // to disable all the text such as showing 1 to 8 entries
                "scrollY": "450px",
                "scrollCollapse": true,
                "paging": false,
                //"iDisplayLength": 15, // how many entries to show in the table
                buttons: [
                        /*{ extend: 'csv', className: 'btn btn-danger '},                    
                        { extend: 'pdf', className: 'btn btn-success '},
                        { extend: 'print', className: 'btn btn-warning '}*/
                        { extend: 'excel', className: 'btn btn-info'},
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