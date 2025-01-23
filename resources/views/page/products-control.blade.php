@extends('..layout.transaction-layout')
@section('title', 'Products Control')
@push('styles')
    @livewireStyles
@endpush
@section('content')
    @livewire('products-control')
@endsection
@push('scripts')
    @livewireScripts
@endpush
