@extends('master')
@section('css-section')
    <style>
        table.sortable th:not(.sorttable_sorted):not(.sorttable_sorted_reverse):not(.sorttable_nosort):after { 
        content: "\25B4" 
    }
    </style>
@endsection
@section('body-section')
<div class="container">    
    <button  type="button" id="export" class="btn btn-danger btn-sm" style="float: right; margin-bottom:5px; margin-right:5px" onclick="exportTableToExcel('print_this_table','ClientPingReport')">Export To Excel</button>
    <div>
        <input type="text" name="reqip" placeholder="Enter IP" id="reqip">
        <button  type="button" id="searchbtn" class="btn btn-success btn-sm" onclick="pingIp()" return false>Ping IP!</button>
        <form method="get" action="serverping" id="serverpingform" style="display: inline">
            <input type="submit" id="pingserverbtn" class="btn btn-warning btn-sm" style="float: ; margin-left: 30%; margin-right: 5px" value="Ping All!"/>
        </form>
    </div>
    <div id="pingdiv"></div>
    <table class="table table-bordered sortable" id="print_this_table" border="1">
        <thead>
            <tr>
                
            </tr>
            <tr>
                <th>S.No</th>
                <th>Bcode</th>
                <th>IPAddress</th>
                <th>Status</th>
            </tr>
        </thead>
        @if(isset($sdetails))
        <tbody>
            @foreach($sdetails as $key=>$value)
            <tr>
                <td>{{ $loop->index+1 }}</td>
                <td>{{ $sdetails[$key]->bcode }}</td>
                <td>{{ $sdetails[$key]->ipaddress }}</td>
                <td>{{ $sdetails[$key]->type }}</td>
            </tr>
            @endforeach
        </tbody>
        @endif
    </table>
</div>
@endsection
@section('js-section')
<script type="text/javascript" src="{{ asset('SortTable/sortable.js') }}"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script>

    function pingIp()
    {
        var searchIP = $('#reqip').val();
        $.ajax({
                type: "POST",
                dataType: "json",
                url: "searchPingIP/"+searchIP,
                data: {'_token': $('meta[name="_token"]').attr('content'), 'reqip': searchIP},
                success: function(results){
                    $('#pingdiv').empty();
                    $('#pingdiv').append("<br><table class='table table-bordered'><thead><tr style='background-color: #ff8080'><th>BCODE</th><th>IP</th><th>Status</th></tr></thead><tbody><tr style='background-color: #ff8080'><td>"+results['bcode']+"</td><td>"+results['ipaddress']+"</td><td>"+results['status']+"</td></tr></tbody></table>");
                }
              });
    }

    $('#serverpingform').on('submit',function(){
        md = confirm('Are You sure to ping all IP Addresses- Might take 15-20 minutes ?');
        if(md)
        {
            return;
        }
        else{
            return false;
        }
        /*swal({
                title: "Are you sure?",
                text: "Ping all the IP Addresses will take 15-20 minutes",
                icon: "warning",
                buttons: true,
                dangerMode: true,
                })
                .then((executeQ) => {
                if (executeQ) 
                {
                    swal("Poof! Your imaginary file has been deleted!", {
                    icon: "success",
                    });
                    return true;
                } 
                else 
                {
                    return false;
                }
            });*/
    });
    
    function exportTableToExcel(tableID, filename = '') {
        var downloadLink;
        var dataType = 'application/vnd.ms-excel';
        var tableSelect = document.getElementById(tableID);
        var tableHTML = tableSelect.outerHTML.replace(/ /g, '%20');

        // Specify file name
        filename = filename ? filename + '.xls' : 'excel_data.xls';

        // Create download link element
        downloadLink = document.createElement("a");

        document.body.appendChild(downloadLink);

        if (navigator.msSaveOrOpenBlob) {
            var blob = new Blob(['\ufeff', tableHTML], {
                type: dataType
            });
            navigator.msSaveOrOpenBlob(blob, filename);
        } else {
            // Create a link to the file
            downloadLink.href = 'data:' + dataType + ', ' + tableHTML;
            // Setting the file name
            downloadLink.download = filename;

            //triggering the function
            downloadLink.click();
        }
    }
</script>
@endsection