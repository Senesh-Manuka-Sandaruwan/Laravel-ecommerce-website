@extends('layouts.master')

@section('title', 'Static Navigation')

@section('body-class', '')

@section('content')
    @include('layouts.header')
    
    <div id="layoutSidenav">
        @include('layouts.sidebar')
        
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Static Navigation</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Static Navigation</li>
                    </ol>
                    <div class="card mb-4">
                        <div class="card-body">
                            <p class="mb-0">
                                This page is an example of using static navigation. By removing the
                                <code>.sb-nav-fixed</code>
                                class from the
                                <code>body</code>
                                , the top navigation and side navigation will become static on scroll. Scroll down this page to see an example.
                            </p>
                        </div>
                    </div>
                    <div style="height: 100vh"></div>
                    <div class="card mb-4"><div class="card-body">When scrolling, the navigation stays at the top of the page. This is the end of the static navigation demo.</div></div>
                </div>
            </main>
            @include('layouts.footer')
        </div>
    </div>
@endsection