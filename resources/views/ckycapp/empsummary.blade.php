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
          <h4 style="text-align: center">CKYC Employee Summary</h4>
        </div>         
        <div class="card-body tab-content" id="myTabContent">
            <form method="post" action="{{ route('emp_summary') }}">
                <div style="float: right">
                    <input type="date" name="edate" @isset($edate) value="{{ $edate }}" @endisset  style="display: inline"/>
                    <input type="submit" name="submit" value="Search" class="btn btn-sm btn-success" style="display: inline"/>
                </div>
            </form>
            <br/><br/>
            <table id="example12" class="display wordwrap" style="width:100%">
                <thead>
                    <tr>
                        {{-- @if(Session::get('employee_id')!=6160)
                        <th>S.No</th>
                        <th>Empid</th>
                        <th>Name</th>
                        <th>Branch</th>
                        <th>No. Accounts</th>
                        <th>Logintime</th>
                        <th>Logouttime</th>
                        @else --}}              
                        <th>S.No</th>
                        <th>Empid</th>
                        <th>Name</th>
                        <th>Branch</th>
                        <th>Region</th>
                        <th>No. Accounts</th>
                        <th>Timediff(Hrs)</th>
                        <th>Avg Accounts</th>
                        <th>Logintime</th>
                        <th>Logouttime</th>    
                        {{-- @endif --}}
                    </tr>                        
                </thead>                    
                @isset($rows1)              
                <tbody>
                    @foreach($emparray as $key1=>$value)
                    <tr>
                        <td>{{ $loop->index+1 }}</td>
                        <td>{{ $emparray[$key1]['empid'] }}</td>
                        <td>@isset($emps[$emparray[$key1]['empid']]){{ $emps[$emparray[$key1]['empid']] }} @else notavail @endisset</td>
                        <td>@isset($empbcodes[$emparray[$key1]['empid']]){{ $empbcodes[$emparray[$key1]['empid']] }} - {{ $branches[$empbcodes[$emparray[$key1]['empid']]] }}  @else notavail @endisset</td>
                        <td>@isset($regions[$empbcodes[$emparray[$key1]['empid']]]){{ $regions[$empbcodes[$emparray[$key1]['empid']]] }} @else notavail @endisset</td>
                        <td>{{ $emparray[$key1]['naccounts'] }}</td>
                        <td>{{ $emparray[$key1]['timediff'] }}</td>
                        <td>{{ $emparray[$key1]['avgaccounts'] }}</td>
                        <td>{{ date('d-m-Y H:i:s',strtotime($emparray[$key1]['logintime'])) }}</td>
                        <td>{{ date('d-m-Y H:i:s',strtotime($emparray[$key1]['logouttime'])) }}</td>
                    </tr>
                    @endforeach 
                    {{-- @endif --}}
                </tbody>       
                @endisset  
                <tfoot align="right">
                    <tr>
                        <th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th>
                    </tr>
                </tfoot>                         
            </table>  
        </div>
    </div> 


    <div class="card bg-light" style="margin-top: 5%">
        <div class="card-header">
          <h4 style="text-align: center">CKYC Region Summary</h4>
        </div>         
        <div class="card-body tab-content" id="myTabContent">
            <div class="container">
                <table id="example13" class="display wordwrap" style="width:100%">
                    <thead>
                        <tr>
                                          
                            <th>S.No</th>
                            <th>Region</th>
                            <th>No. Accounts</th>    
                        </tr>                        
                    </thead>                    
                    @isset($onlyreg)              
                    <tbody>
                        @foreach($onlyreg as $key1=>$value)
                        <tr>
                            <td>{{ $loop->index+1 }}</td>
                            <td>{{ $key1 }}</td>
                            <td>{{ $onlyreg[$key1] }}</td>
                        </tr>
                        @endforeach 
                    </tbody>       
                    @endisset  
                                             
                </table> 
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
                "footerCallback": function ( row, data, start, end, display ) {
                        var api = this.api(), data;
            
                        // converting to interger to find total
                        var intVal = function ( i ) {
                            return typeof i === 'string' ?
                                i.replace(/[\$,]/g, '')*1 :
                                typeof i === 'number' ?
                                    i : 0;
                        };
            
                        // computing column Total of the complete result 
                           
                        var wedTotal = api
                            .column( 5 )
                            .data()
                            .reduce( function (a, b) {
                                return intVal(a) + intVal(b);
                            }, 0 );
                            
                    

                            
                        // Update footer by showing the total with the reference of the column index 
                        $( api.column( 0 ).footer() ).html('#');
                        $( api.column( 1 ).footer() ).html('Total');
                        $( api.column( 2 ).footer() ).html(wedTotal);
                        $( api.column( 3 ).footer() ).html();
                        $( api.column( 4 ).footer() ).html();
                        $( api.column( 5 ).footer() ).html();
                        
                    },
            });

            $('#example13').DataTable({
                dom: 'Bfrtip',
                paginate: false, // pagination is set to false
                info: false, // to disable all the text such as showing 1 to 8 entries
                
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

        </script>
@endsection










