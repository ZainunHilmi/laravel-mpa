@extends('layouts.app')

@section('title', 'Activities')

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Activities</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item">Activities</div>
                </div>
            </div>
            <div class="section-body">
                <h2 class="section-title">{{ date('F Y') }}</h2>
                <div class="row">
                    <div class="col-12">
                        <div class="activities">
                            @foreach ($activities as $activity)
                                <div class="activity">
                                    <div class="activity-icon bg-{{ $activity->color }} text-white shadow-primary">
                                        <i class="{{ $activity->icon }}"></i>
                                    </div>
                                    <div class="activity-detail">
                                        <div class="mb-2">
                                            <span
                                                class="text-job text-primary">{{ $activity->created_at->diffForHumans() }}</span>
                                            <span class="bullet"></span>
                                            <a class="text-job" href="#">View</a>
                                        </div>
                                        <p>{{ $activity->message }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
@endpush