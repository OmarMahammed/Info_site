@extends('layouts.app')

@section('title', __('trust') . ' — ' . config('app.name'))

@section('content')
    <section data-animate class="hidden-anim pb-20 transform-gpu" data-motion-group>
        <x-sections.trust :content="$trustContent" />
    </section>
@endsection