@extends('layouts.app')

@section('title', 'Test Page')

@section('content')
<div class="container">
    <h1>Test Page Works!</h1>
    <p>This is a simple test to see if the layout is working.</p>
    <p>Sections count: {{ $sections->count() ?? 'No sections variable' }}</p>
</div>
@endsection
