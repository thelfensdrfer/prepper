@extends('layouts.app')

@section('content')
    <div class="clearfix">
        <h2 class="block float-left">
            {{ __('Checklists') }}
        </h2>

        <create-checklist></create-checklist>
    </div>

    <checklists :lists='@json($checklists)'></checklists>
@endsection
