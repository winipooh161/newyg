@extends('layouts.app')
@section('content')
    @include('layouts/header')
    @include('home/page')
    @include('home/info')
    @include('information/information-one')
    @include('home/advantages')
    @include('form/form-one')
    {{-- @include('home/cards') --}}
    @include('home/colaboration')
    @include('information/information-two')
    @include('home/services')
    @include('form/form-two')
    @include('gallery/gallery')
    @include('information/information-tree')
    {{-- @include('home/map') --}}
    {{-- @include('form/form-three') --}}
    @include('home/tabs')
    @include('home/feedback')
    @include('home/avtor')
   
    {{-- @include('home/team') --}}
    {{-- @include('home/faq') --}}
    {{-- @include('form/form-five') --}}
    {{-- @include('home/partners') --}}
    @include('layouts/quiz')
    @include('layouts/footer')
@endsection
