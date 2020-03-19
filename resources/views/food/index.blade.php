@extends('layouts.app')

@section('content')
    <h2>{{ __('Food and water') }}</h2>

    <food-groups :food_groups='@json($foodGroups)'></food-groups>
@endsection
