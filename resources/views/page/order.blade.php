@extends('..layout.buyer-layout')
@section('title', 'Online Shop')
@push('styles')
    @livewireStyles
@endpush
@section('content')
    <section>
        <div class="container px-4">
            <div class="row col-12 justify-content-center">
                @livewire('order-detail')
            </div>
        </div>
    </section>
@endsection
@push('scripts')
    @livewireScripts
@endpush
