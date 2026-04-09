@extends('layouts.app')

@section('content')
<div class="container">
    <div
        id="vue-app"
        data-page="transfers-index"
        data-dashboard-url="{{ route('dashboard') }}"
        data-transfer-create-url="{{ route('transfers.create') }}"
        data-transfers='@json($transfers)'
    ></div>
</div>
@endsection
