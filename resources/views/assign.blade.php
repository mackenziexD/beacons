@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Fuel Assign') }}</div>

                <div class="card-body">
                    <form action="">
                        @csrf
                        <div class="form-group">
                            <label for="constellations">Split Systems By:</label>
                            <input class="typeahead form-control col-md-11" type="number" name="splitBy" id="splitBy" placeholder="10 People">
                        </div>
                        <div class="d-grid">
                            <button class="btn btn-primary mt-2" type="submit">Generate Assignment</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
