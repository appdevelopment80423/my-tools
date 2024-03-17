@extends('admin.layout.main')
@section('title', 'Dashboard')
@section('content')
    <style>
        .clickable-div:hover{
            border: 2px solid #1a1b20eb;
            cursor: pointer;
        }
    </style>
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row gy-4">
            <div class="col-lg-4 col-sm-6">
                <div class="card h-100 clickable-div">
                    <a href="#">
                    <div class="row">
                        <div class="col-6">
                            <div class="card-body">
                                <div class="card-info mb-3 py-2 mb-lg-1 mb-xl-3">
                                    <h3 class="mb-3 mb-lg-2 mb-xl-3 text-nowrap">Rupees</h3>
                                    <div class="  lh-xs">
                                        <h5> My Earning</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 text-end d-flex align-items-end justify-content-center">
                            <div class="card-body">
                                <img loading="lazy" src="{{ asset('assets/img/dashboard/myearning.png') }}" alt="Ratings" width="95">
                            </div>
                        </div>
                    </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
