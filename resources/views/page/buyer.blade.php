@extends('..layout.buyer-layout')
@section('title', 'Online Shop')
@push('styles')
    @livewireStyles
@endpush
@section('content')
    @livewire('buyer-page')
@endsection
@push('scripts')
    @livewireScripts
@endpush
