@extends('layouts.app')

@section('content')
    <h2>{{ __('Overview') }}</h2>

    <food-groups :food_groups='@json($foodGroups)'></food-groups>
@endsection
