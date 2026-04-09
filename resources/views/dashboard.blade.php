@extends('layouts.app')

@section('content')
<div class="container">
    <div
        id="vue-app"
        data-page="dashboard"
        data-user-name="{{ $user->name }}"
        data-balance="{{ $user->wallet->balance ?? 0 }}"
        data-transfer-url="{{ route('transfers.create') }}"
        data-transactions-url="{{ route('transactions.index') }}"
    ></div>
</div>
@endsection
