@extends('..layout.transaction-layout')
@section('title', 'Customer Service Layer 2')
@push('styles')
    @livewireStyles
@endpush
@section('content')
@livewire('cs-layer2')
@endsection
@push('scripts')
    @livewireScripts
@endpush
