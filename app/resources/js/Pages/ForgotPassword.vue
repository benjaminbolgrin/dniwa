<script setup>
import DniwaHead from '@/Components/DniwaHead.vue';
import MainLayout from '@/Layout/MainLayout.vue';
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';

const resetSuccess = ref(false);
const labelEmail = 'Email';
const headlineReset = 'Reset password';
const forgotInfoText = 'Forgot your password? Please let us know your email address and we\'ll send you a reset link.';
const alertSuccess = 'A reset link has been send to your email.';
const submitButton = 'Reset password';

let forgotForm = useForm({
	email: ''
});

let submit = () => {
	forgotForm.post('/forgot-password', {
		onSuccess: () => {
			resetSuccess.value = true;
		}
	});
};
</script>

<template>
	<DniwaHead title="Password reset" />
	<MainLayout>
		<div class="row">
			<div class="col"></div>
			<div class="col-6">
				<div v-if="resetSuccess" v-text="alertSuccess" class="alert alert-success"/>
				<div class="p-4 bg-secondary-subtle border border-secondary-subtle">
					<form @submit.prevent="submit">
						<h1 class="mb-5" v-text="headlineReset"/>
						<span v-text="forgotInfoText"/>
						<div class="form-group mt-3 mb-3">
							<label for="email" v-text="labelEmail" class="form-label"/>
							<input v-model="forgotForm.email" type="email" class="form-control" required autofocus/>
							<div v-if="forgotForm.errors.email" v-text="forgotForm.errors.email" class="text-danger"/>
						</div>
						<button type="submit" class="btn btn-primary" :disabled="forgotForm.processing" v-text="submitButton"/>
					</form>
				</div>
			</div>
			<div class="col"></div>
		</div>
	</MainLayout>
</template>
