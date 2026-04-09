<template>
    <section class="card border-0 shadow-sm">
        <div class="card-body p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="h3 mb-1">Transferências</h1>
                    <p class="text-body-secondary mb-0">
                        Últimas transferências enviadas e recebidas.
                    </p>
                </div>

                <div class="d-flex gap-2">
                    <a :href="dashboardUrl" class="btn btn-outline-secondary">
                        Voltar
                    </a>
                    <a :href="transferCreateUrl" class="btn btn-primary">
                        Nova Transferência
                    </a>
                </div>
            </div>

            <div v-if="transfers.length" class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead>
                        <tr>
                            <th>Data</th>
                            <th>Tipo</th>
                            <th>Valor</th>
                            <th>Usuário envolvido</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr v-for="transfer in transfers" :key="transfer.id">
                            <td>{{ formatDate(transfer.created_at) }}</td>

                            <td>
                                <span
                                    class="badge"
                                    :class="transfer.direction === 'sent' ? 'bg-danger' : 'bg-success'"
                                >
                                    {{ transfer.direction === 'sent' ? 'Enviada' : 'Recebida' }}
                                </span>
                            </td>

                            <td>
                                <strong
                                    :class="transfer.direction === 'sent' ? 'text-danger' : 'text-success'"
                                >
                                    {{ transfer.direction === 'sent' ? '-' : '+' }}{{ formatCurrency(transfer.value) }}
                                </strong>
                            </td>

                            <td>
                                <template v-if="transfer.counterparty">
                                    {{ transfer.counterparty.name }}<br>
                                    <small class="text-body-secondary">
                                        {{ transfer.counterparty.email }}
                                    </small>
                                </template>

                                <span v-else class="text-body-secondary">
                                    Não identificado
                                </span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div v-else class="alert alert-light border mb-0">
                Nenhuma transferência encontrada.
            </div>
        </div>
    </section>
</template>

<script setup>
defineProps({
    dashboardUrl: {
        type: String,
        default: '',
    },
    transferCreateUrl: {
        type: String,
        default: '',
    },
    transfers: {
        type: Array,
        default: () => [],
    },
});

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
