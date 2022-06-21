@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Fuel Dashboard') }}</div>

                <div class="card-body">
                    
                    <div class="alert alert-primary" role="alert">
                        <i class="fas fa-exclamation-triangle" style="color: #222;"></i> <strong> REMINDER! </strong>  Beacons require 1080 fuelblocks to online.
                    </div>
                    <table id="fuel" class="table table-striped table-borderedt">
                        <thead class="thead-light">
                            <tr>
                                <th>System</th>
                                <th>Name</th>
                                <th>Constellation</th>
                                <th>Fuel Expires In (Days)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php echo $tableData @endphp
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
