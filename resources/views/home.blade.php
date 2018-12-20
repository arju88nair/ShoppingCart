@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="loading"></div>

        <div class="row justify-content-center">
            <div class="col-md-12">
@include('partials.products')
            </div>
        </div>
    </div>
@endsection
