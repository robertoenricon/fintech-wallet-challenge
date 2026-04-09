<template>
    <section class="card border-0 shadow-sm">
        <div class="card-body p-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h1 class="h3 mb-0">Dashboard</h1>

                <div class="d-flex gap-2">
                    <a :href="transferUrl" class="btn btn-success">
                        Nova Transferência
                    </a>

                    <a :href="transfersUrl" class="btn btn-outline-secondary">
                        Transferências
                    </a>

                    <a :href="transactionsUrl" class="btn btn-outline-primary">
                        Histórico
                    </a>
                </div>
            </div>

            <p class="mb-2">
                <strong>{{ userName }}</strong>
            </p>

            <p class="mb-0">
                Saldo:
                <strong>{{ formattedBalance }}</strong>
            </p>

            <hr class="my-4">

            <div class="d-flex justify-content-between align-items-center mb-3">
                <h2 class="h5 mb-0">Últimas 5 transações</h2>
                <a :href="transactionsUrl" class="btn btn-sm btn-outline-primary">
                    Ver histórico completo
                </a>
            </div>

            <div v-if="recentTransactions.length" class="list-group">
                <div
                    v-for="transaction in recentTransactions"
                    :key="transaction.id"
                    class="list-group-item border-start-0 border-end-0 px-0"
                >
                    <div class="d-flex justify-content-between align-items-start gap-3">
                        <div>
                            <div class="d-flex align-items-center gap-2 mb-1">
                                <span
                                    class="badge"
                                    :class="transaction.type === 'debit' ? 'bg-danger' : 'bg-success'"
                                >
                                    {{ transaction.type === 'debit' ? 'Débito' : 'Crédito' }}
                                </span>

                                <small class="text-body-secondary">
                                    {{ formatDate(transaction.created_at) }}
                                </small>
                            </div>

                            <div v-if="transaction.involved_user">
                                <strong>{{ transaction.involved_user.name }}</strong>
                                <div class="text-body-secondary small">
                                    {{ transaction.involved_user.email }}
                                </div>
                            </div>

                            <div v-else class="text-body-secondary small">
                                Usuário não identificado
                            </div>

                            <div
                                v-if="transaction.description"
                                class="text-body-secondary small mt-1"
                            >
                                {{ transaction.description }}
                            </div>
                        </div>

                        <strong
                            :class="transaction.type === 'debit' ? 'text-danger' : 'text-success'"
                        >
                            {{ transaction.type === 'debit' ? '-' : '+' }}{{ formatCurrency(transaction.value) }}
                        </strong>
                    </div>
                </div>
            </div>

            <div v-else class="alert alert-light border mb-0">
                Nenhuma transação encontrada.
            </div>
        </div>
    </section>
</template>

<script setup>
import { computed } from 'vue';

const props = defineProps({
    userName: {
        type: String,
        default: '',
    },
    balance: {
        type: Number,
        default: 0,
    },
    transferUrl: {
        type: String,
        default: '',
    },
    transactionsUrl: {
        type: String,
        default: '',
    },
    transfersUrl: {
        type: String,
        default: '',
    },
    recentTransactions: {
        type: Array,
        default: () => [],
    },
});

const formattedBalance = computed(() => (
    formatCurrency(props.balance)
));

function formatCurrency(value) {
    return new Intl.NumberFormat('pt-BR', {
        style: 'currency',
        currency: 'BRL',
    }).format(Number(value) || 0);
}

function formatDate(value) {
    if (!value) {
        return '-';
    }

    return new Intl.DateTimeFormat('pt-BR', {
        dateStyle: 'short',
        timeStyle: 'short',
    }).format(new Date(value));
}
</script>
