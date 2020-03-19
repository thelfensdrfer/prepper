@extends('layouts.app')

@section('content')
    <h2>{{ __('Checklists') }}</h2>

    <checklists :checklists='@json($checklists)'></checklists>
@endsection
