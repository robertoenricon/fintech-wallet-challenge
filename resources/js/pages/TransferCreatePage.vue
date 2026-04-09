<template>
    <section class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h1 class="h3 mb-0">Transferência</h1>
                        <a :href="dashboardUrl" class="btn btn-outline-secondary">
                            Voltar
                        </a>
                    </div>

                    <div
                        v-if="successMessage"
                        class="alert alert-success"
                    >
                        {{ successMessage }}
                    </div>

                    <div
                        v-if="errorMessages.length"
                        class="alert alert-danger"
                    >
                        <ul class="mb-0 ps-3">
                            <li v-for="message in errorMessages" :key="message">
                                {{ message }}
                            </li>
                        </ul>
                    </div>

                    <form @submit.prevent="submitTransfer">
                        <div class="mb-3">
                            <label for="transfer-email" class="form-label">
                                E-mail do destinatário
                            </label>
                            <input
                                id="transfer-email"
                                v-model="email"
                                type="email"
                                class="form-control"
                                required
                            >
                        </div>

                        <div class="mb-4">
                            <label for="transfer-value" class="form-label">
                                Valor
                            </label>
                            <input
                                id="transfer-value"
                                v-model="value"
                                type="number"
                                step="0.01"
                                min="0.01"
                                class="form-control"
                                required
                            >
                        </div>

                        <button
                            type="submit"
                            class="btn btn-primary w-100"
                            :disabled="isSubmitting"
                        >
                            {{ isSubmitting ? 'Transferindo...' : 'Transferir' }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>
</template>

<script setup>
import { ref } from 'vue';

const props = defineProps({
    storeUrl: {
        type: String,
        default: '',
    },
    dashboardUrl: {
        type: String,
        default: '',
    },
    initialEmail: {
        type: String,
        default: '',
    },
    initialValue: {
        type: String,
        default: '',
    },
});

const email = ref(props.initialEmail);
const value = ref(props.initialValue);
const isSubmitting = ref(false);
const successMessage = ref('');
const errorMessages = ref([]);

async function submitTransfer() {
    if (!props.storeUrl || isSubmitting.value) {
        return;
    }

    isSubmitting.value = true;
    successMessage.value = '';
    errorMessages.value = [];

    try {
        const response = await window.axios.post(props.storeUrl, {
            email: email.value,
            value: value.value,
        });

        successMessage.value = response.data.message ?? 'Transferência realizada com sucesso.';
        value.value = '';
    } catch (error) {
        const response = error.response;

        if (response?.status === 422) {
            const validationErrors = response.data?.errors;

            if (validationErrors) {
                errorMessages.value = Object.values(validationErrors).flat();
            } else if (response.data?.message) {
                errorMessages.value = [response.data.message];
            }
        } else {
            errorMessages.value = ['Não foi possível realizar a transferência.'];
        }
    } finally {
        isSubmitting.value = false;
    }
}
</script>
