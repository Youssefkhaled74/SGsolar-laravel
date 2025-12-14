@extends('layouts.app')

@section('title', __('website.feedback.title') . ' - ' . __('website.company_name'))

@section('content')
    @include('partials.home-feedback', ['feedbacks' => config('website.testimonials', [])])
@endsection
