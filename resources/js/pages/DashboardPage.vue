<template>
    <section class="card border-0 shadow-sm">
        <div class="card-body p-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h1 class="h3 mb-0">Dashboard</h1>

                <div class="d-flex gap-2">
                    <a :href="transferUrl" class="btn btn-success">
                        Nova Transferência
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
});

const formattedBalance = computed(() => (
    new Intl.NumberFormat('pt-BR', {
        style: 'currency',
        currency: 'BRL',
    }).format(props.balance)
));
</script>
