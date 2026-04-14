@extends('layouts.app')

@section('title', __('site.nav.trust-conversion') . ' — ' . config('app.name'))

@section('content')
    <section data-animate class="hidden-anim pb-20 transform-gpu" data-motion-group>
        <x-sections.trust-conversion :content="$trustContent" />
    </section>
@endsection