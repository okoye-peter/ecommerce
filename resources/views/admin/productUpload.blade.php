@extends('layouts.adminLayout')

@section('content')
    <div class="container">
        <div class="row justify-content-center mb-3">
            <div
                class="col-12 bg-darkrounded py-3 my-2"
            >
                
                <drop-zone token="{{csrf_token()}}" />
            </div>
        </div>
    </div>
@endsection
