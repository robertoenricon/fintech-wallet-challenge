@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card shadow-sm border-0">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0">Histórico de Transações</h1>

                <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary">
                    Voltar ao Dashboard
                </a>
            </div>

            <form method="GET" action="{{ route('transactions.index') }}" class="row g-3 mb-4">
                <div class="col-md-3">
                    <label for="type" class="form-label">Tipo</label>
                    <select name="type" id="type" class="form-select">
                        <option value="">Todos</option>
                        <option value="debit" {{ request('type') === 'debit' ? 'selected' : '' }}>
                            Débito
                        </option>
                        <option value="credit" {{ request('type') === 'credit' ? 'selected' : '' }}>
                            Crédito
                        </option>
                    </select>
                </div>

                <div class="col-md-3">
                    <label for="start_date" class="form-label">Data inicial</label>
                    <input
                        type="date"
                        name="start_date"
                        id="start_date"
                        value="{{ request('start_date') }}"
                        class="form-control"
                    >
                </div>

                <div class="col-md-3">
                    <label for="end_date" class="form-label">Data final</label>
                    <input
                        type="date"
                        name="end_date"
                        id="end_date"
                        value="{{ request('end_date') }}"
                        class="form-control"
                    >
                </div>

                <div class="col-md-3 d-flex align-items-end gap-2">
                    <button type="submit" class="btn btn-primary w-100">
                        Filtrar
                    </button>

                    <a href="{{ route('transactions.index') }}" class="btn btn-outline-secondary w-100">
                        Limpar
                    </a>
                </div>
            </form>

            @if($transactions->count())
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr>
                                <th>Data</th>
                                <th>Tipo</th>
                                <th>Valor</th>
                                <th>Usuário envolvido</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($transactions as $transaction)
                                @php
                                    $transfer = $transaction->transfer;

                                    $involvedUser = null;

                                    if ($transfer) {
                                        $involvedUser = $transaction->type === 'debit'
                                            ? $transfer->recipient
                                            : $transfer->sender;
                                    }
                                @endphp

                                <tr>
                                    <td>{{ $transaction->created_at->format('d/m/Y H:i') }}</td>

                                    <td>
                                        @if($transaction->type === 'debit')
                                            <span class="badge bg-danger">Débito</span>
                                        @else
                                            <span class="badge bg-success">Crédito</span>
                                        @endif
                                    </td>

                                    <td>
                                        R$ {{ number_format($transaction->amount, 2, ',', '.') }}
                                    </td>

                                    <td>
                                        @if($involvedUser)
                                            {{ $involvedUser->name }} <br>
                                            <small class="text-muted">{{ $involvedUser->email }}</small>
                                        @else
                                            <span class="text-muted">Não identificado</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-3">
                    {{ $transactions->links() }}
                </div>
            @else
                <div class="alert alert-light border mb-0">
                    Nenhuma transação encontrada para os filtros informados.
                </div>
            @endif
        </div>
    </div>
</div>
@endsection