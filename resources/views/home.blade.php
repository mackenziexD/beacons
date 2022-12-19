@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Fuel Dashboard') }}</div>

                <div class="card-body">

                @if(session('success'))
                    <div class="col-md-12 text-center">
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    </div>
                @endif

                <button type="button" class="btn btn-primary mb-4" onclick="exportTableToCSV('fuel')">Export to CSV</button>
                <button type="button" class="btn btn-primary mb-4" onclick="selectElementContents( document.getElementById('fuel') );">Export to Text</button>
                
                    
                    <div class="alert alert-primary" role="alert">
                        <i class="fas fa-exclamation-triangle" style="color: #222;"></i> <strong> REMINDER! </strong>  Beacons require 1080 fuelblocks to online.
                    </div>
                    <table id="fuel" class="table table-striped table-borderedt">
                        <thead class="thead-light">
                            <tr>
                                <th>System</th>
                                <th>Name</th>
                                <th>Constellation</th>
                                <th>Region</th>
                                <th>Fuel Expires In (Days)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php echo $tableData @endphp
                        </tbody>
                    </table>
                </div>
                <div class="card-footer">
                    Last Updated: {{$updatedAt}}
                    <span class="float-end">Remember ESI's update every 15min so changes might take abit to show.</span>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
function exportTableToCSV(table_id, separator = ',') {
    // expend datatable 
    var table = $('#' + table_id).DataTable();
    // redraw table with all data
    table.destroy();
    // Select rows from table_id
    var rows = document.querySelectorAll('table#' + table_id + ' tr');
    // Construct csv
    var csv = [];
    for (var i = 0; i < rows.length; i++) {
        var row = [], cols = rows[i].querySelectorAll('td, th');
        for (var j = 0; j < cols.length; j++) {
            // Clean innertext to remove multiple spaces and jumpline (break csv)
            var data = cols[j].innerText.replace(/(\r\n|\n|\r)/gm, '').replace(/(\s\s)/gm, ' ')
            // Escape double-quote with double-double-quote (see https://stackoverflow.com/questions/17808511/properly-escape-a-double-quote-in-csv)
            data = data.replace(/"/g, '""');
            // Push escaped string
            row.push('"' + data + '"');
        }
        csv.push(row.join(separator));
    }
    var csv_string = csv.join('\n');
    // Download it
    var filename = 'export_' + table_id + '_' + new Date().toLocaleDateString() + '.csv';
    var link = document.createElement('a');
    link.style.display = 'none';
    link.setAttribute('target', '_blank');
    link.setAttribute('href', 'data:text/csv;charset=utf-8,' + encodeURIComponent(csv_string));
    link.setAttribute('download', filename);
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
    // set table to original state
    var table = $('#fuel').DataTable( {
                "oLanguage": {
                "sLengthMenu": "Show  _MENU_",
                },
                "orderable": true,
                "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "Show All"]],
                "order": [[ 4, "asc" ]],
            });
}
// create function that will copy the table to clipboard
function selectElementContents(el) {
    // expend datatable 
    var table = $('#fuel').DataTable();
    table.destroy();
	var body = document.body, range, sel;
	if (document.createRange && window.getSelection) {
		range = document.createRange();
		sel = window.getSelection();
		sel.removeAllRanges();
		try {
			range.selectNodeContents(el);
			sel.addRange(range);
		} catch (e) {
			range.selectNode(el);
			sel.addRange(range);
		}
	} else if (body.createTextRange) {
		range = body.createTextRange();
		range.moveToElementText(el);
		range.select();
	}
    document.execCommand("Copy");
    var table = $('#fuel').DataTable( {
                "oLanguage": {
                "sLengthMenu": "Show  _MENU_",
                },
                "orderable": true,
                "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "Show All"]],
                "order": [[ 4, "asc" ]],
            });
}
</script>
@endsection
