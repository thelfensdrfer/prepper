@extends('layouts.app')

@section('content')
    <h2>{{ __('Overview') }}</h2>

    <food-groups :groups='@json($foodGroups)'></food-groups>
@endsection
