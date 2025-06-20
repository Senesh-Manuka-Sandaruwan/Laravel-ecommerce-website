@extends('layouts.master')

@section('title', '500 Error')

@section('content')
<div id="layoutError">
    <div id="layoutError_content">
        <main>
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-6">
                        <div class="text-center mt-4">
                            <h1 class="display-1">500</h1>
                            <p class="lead">Internal Server Error</p>
                            <a href="{{ route('dashboard') }}">
                                <i class="fas fa-arrow-left me-1"></i>
                                Return to Dashboard
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
    <div id="layoutError_footer">
        @include('layouts.footer')
    </div>
</div>
@endsection