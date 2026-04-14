@extends('layouts.app')

@section('title', __('site.nav.about') . ' — ' . config('app.name'))

@section('content')

    <section class="pb-20">
        <x-sections.about :content="$aboutContent" />
    </section>

@endsection