@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Payment Confirmation</h1>
        <p>Your payment was successful.</p>
        <p>Your latest property posting duration is {{ $newDuration }} days.</p>
    </div>
@endsection
