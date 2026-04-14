@extends('layouts.app')

@section('title', __('services') . ' — ' . config('app.name'))

@section('content')
    <section data-animate class="hidden-anim pb-20 transform-gpu" data-motion-group>
        <x-sections.services :content="$servicesContent" />
    </section>
@endsection