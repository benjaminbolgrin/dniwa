<script setup>
import DniwaHead from '@/Components/DniwaHead.vue';
import MainLayout from '@/Layout/MainLayout.vue';
import {ref} from 'vue';
import {useForm, Link} from '@inertiajs/inertia-vue3';

let headlineMain = ref('Sign up');
let labelName = ref('Name');
let labelEmail = ref('Email');
let labelPassword = ref('Password');
let labelPasswordConfirmation = ref('Confirm password');
let submitButton = ref('Sign up');
let signinLink = ref('Already have an account? Sign in!');

let signupForm = useForm({
	name: '',
	email: '',
	password: '',
	password_confirmation: ''
});

let submit = () =>{
	signupForm.post('/signup');
};

</script>

<template>
	<DniwaHead title="Sign up"/>
	<MainLayout>
		<div class="row"> 	
			<div class="col"></div>
			<div class="col-6">
				<div class="p-4 bg-secondary-subtle border border-secondary-subtle">
					<h1 class="mb-5">{{ headlineMain }}</h1>
					<form @submit.prevent="submit">
						<!-- Name -->
						<div class="form-group mb-3">
							<label for="name" class="form-label" v-text="labelName"/>
							<input v-model="signupForm.name" class="form-control" type="text" required autofocus/>
							<div v-if="signupForm.errors.name" v-text="signupForm.errors.name" class="text-danger"/>
						</div>

						<!-- Email Address -->
						<div class="form-group mb-3">
							<label for="email" v-text="labelEmail" class="form-label"/>
							<input v-model="signupForm.email" class="form-control" type="email" required/>
							<div v-if="signupForm.errors.email" v-text="signupForm.errors.email" class="text-danger"/>
						</div>

						<!-- Password -->
						<div class="form-group mb-3">
							<label for="password" class="form-label" v-text="labelPassword"/>
							<input v-model="signupForm.password" class="form-control" type="password" required />
							<div v-if="signupForm.errors.password" v-text="signupForm.errors.password" class="text-danger"/>
						</div>

						<!-- Confirm Password -->
						<div class="form-group mb-3">
							<label for="password_confirmation" class="form-label" v-text="labelPasswordConfirmation"/>
							<input v-model="signupForm.password_confirmation" class="form-control" type="password" required />
							<div v-if="signupForm.errors.password_confirmation" v-text="signupForm.errors.password_confirmation" class="text-danger"/>
						</div>
						<button type="submit" class="btn btn-primary" :disabled="signupForm.processing">
							{{ submitButton }}
						</button>
					</form>
				</div>
			<span class="text text-primary">
				<Link href="/signin" v-text="signinLink"/>
			</span>
			</div>
			<div class="col"></div>
		</div>
	</MainLayout>
</template>
