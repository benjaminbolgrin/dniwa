<script setup>
import MainLayout from '@/Layout/MainLayout.vue';
import DniwaHead from '@/Components/DniwaHead.vue';
import { useForm, Link } from '@inertiajs/vue3';

const labelEmail = 'Email';
const labelPassword = 'Password';
const labelRememberMe = 'Remember me';
const submitButton = 'Sign in';
const linkForgot = 'Forgot password';
const linkSignup = 'Don\'t have an account yet? Sign up now!';

let formSignin = useForm({
	email: '',
	password: '',
	remember_me: false,
});

let submit = () => {
	formSignin.post('/signin')
};
</script>

<template>
	<DniwaHead title="Sign in" />
	<MainLayout>
		<div class="row">
			<div class="col"></div>
			<div class="col-6">
				<div class="p-4 bg-secondary-subtle border border-secondary-subtle">
					<h1 class="mb-5">Sign in</h1>
					<form @submit.prevent="submit">
						<!-- Email Address -->
						<div class="form-group mb-3">
							<label for="email" class="form-label" v-text="labelEmail"/>
							<input v-model="formSignin.email" class="form-control" type="email"/>
							<div v-if="formSignin.errors.email" v-text="formSignin.errors.email" class="text-danger"/>
						</div>
						<!-- Password -->
						<div class="form-group mb-3">
							<label for="password" class="form-label" v-text="labelPassword"/>
							<input class="form-control" type="password" required v-model="formSignin.password"/>
							<div v-if="formSignin.errors.password" v-text="formSignin.errors.password" class="text-danger"/>
						</div>
						<!-- Remember Me -->
						<div class="form-check">
							<input type="checkbox" class="form-check-input" v-model="formSignin.remember_me"/>
							<label for="remember_me" class="form-check-label" v-text="labelRememberMe"/>
							<div v-if="formSignin.errors.remember_me" v-text="formSignin.errors.remember_me" class="text-danger"/>
						</div>
						<button type="submit" class="btn btn-primary mt-3" :disabled="formSignin.processing" v-text="submitButton"/>
					</form>
					<div class="d-flex justify-content-center mt-4">
						<span class="text text-secondary">
							<Link class="text-secondary" href="forgot-password" v-text="linkForgot"/>
						</span>
					</div>
				</div>
				<span class="text text-primary">
					<Link href="/signup" v-text="linkSignup"/>
				</span>
			</div>
			<div class="col"></div>
		</div>
	</MainLayout>
</template>
