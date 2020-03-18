@component('mail::message')

# Food expires

The following items from your stock are about to expire in the next 30 days:

@foreach($foods as $food)
* {{ $food->name }} ({{ $food->expired_after->format('Y-m-d') }})
@endforeach

{{ config('app.name') }}
@endcomponent
