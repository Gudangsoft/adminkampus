@extends('layouts.admin')

@section('content')
@yield('content')
@endsection

@section('title')
@yield('title')
@endsection

@push('styles')
@stack('styles')
@endpush

@push('scripts')
@stack('scripts')
@endpush
