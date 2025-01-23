@extends('..layout.transaction-layout')
@section('title', 'Customer Service Layer 1')
@push('styles')
    @livewireStyles
@endpush
@section('content')
@livewire('cs-layer1')
@endsection
@push('scripts')
    @livewireScripts
@endpush
