<script setup>
import DniwaHead from '@/Components/DniwaHead.vue';
import MainLayout from '@/Layout/MainLayout.vue';
import { ref } from 'vue';
import { useForm } from '@inertiajs/inertia-vue3';

let props = defineProps({
	status: String
});

let labelEmail = ref('Email');
let headlineReset = ref('Reset password');
let forgotInfoText = ref('Forgot your password? Please let us know your email address and we\'ll send you a reset link.');
let alertSuccess = ref('A reset link has been send to your email.');
let submitButton = ref('Reset password');

let forgotForm = useForm({
	email: ''
});

let submit = () => {
	forgotForm.post('/forgot-password', {
		onSuccess: () => {
			props.status = 'reset-success';
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
				<div v-if="props.status =='reset-success'" v-text="alertSuccess" class="alert alert-success"/>
				<div class="p-4 bg-secondary-subtle border border-secondary-subtle">
					<form @submit.prevent="submit">
						<h1 class="mb-5" v-text="headlineReset"/>
						<span v-text="forgotInfoText"/>
						<div class="form-group mt-3 mb-3">
							<label for="email" v-text="labelEmail" class="form-label"/>
							<input v-model="forgotForm.email" type="email" class="form-control" required autofocus/>
							<div v-if="forgotForm.errors.email" v-text="forgotForm.errors.email"/>
						</div>
						<button type="submit" class="btn btn-primary" :disabled="forgotForm.processing" v-text="submitButton"/>
					</form>
				</div>
			</div>
			<div class="col"></div>
		</div>
	</MainLayout>
</template>
