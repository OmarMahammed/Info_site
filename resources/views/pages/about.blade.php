@extends('layouts.app')

@section('title', __('site.meta.about_title') . ' — ' . config('app.name'))

@section('content')

    <section class="pb-20">
        <x-sections.about :content="$aboutContent" />
    </section>

@endsection