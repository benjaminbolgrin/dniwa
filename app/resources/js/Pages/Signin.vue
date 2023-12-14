<template>
	<DniwaHead title="Sign in" />
	<MainLayout>
		<div class="row">
			<div class="col"></div>
			<div class="col">
				<div class="p-4 bg-secondary-subtle border border-secondary-subtle">
					<h1 class="mb-5">Sign in</h1>

					<form @submit.prevent="submit">

						<!-- Email Address -->
						<div class="form-group mb-3">
							<label for="email" :value="Email" class="form-label"/>
							<input v-model="form.email" placeholder="Email" class="form-control" id="email" type="email"/>
						</div>

						<!-- Password -->
						<div class="form-group mb-3">
							<label for="password" :value="Password" class="form-label" />
							<input id="password" class="form-control" type="password" name="password" required autocomplete="current-password" v-model="form.password"/>
						</div>

						<!-- Remember Me -->
						<div class="form-group mb-3">
							<label for="remember_me" class="form-label" />
							<input id="remember_me" type="checkbox" class="form-check-input" name="remember" v-model="form.checked"/>
							<span>Remember me</span>
						</div>

						<button type="submit" class="btn btn-outline-info" @click="submit">
							Sign in
						</button>
					</form>
					<div class="d-flex justify-content-center mt-4">
						<span class="text text-secondary">
							<a class="text-secondary" href="/auth/forgot-password">
								Forgot password?
							</a>
						</span>
					</div>
				</div>
				<span class="text text-primary">
					<a href="{{route('register')}}">
						Don't have an account yet? Sign up now!
					</a>
				</span>
			</div>
			<div class="col"></div>
		</div>
	</MainLayout>
</template>
<script setup>
	import MainLayout from "@/Layout/MainLayout.vue";
	import DniwaHead from "@/Components/DniwaHead.vue";
	import { useForm } from '@inertiajs/inertia-vue3';

	let form = useForm({
		email: '',
		password: '',
		remember_me: false,
	});
	
	let submit = () => {
		form.post('/signin')
	};
</script>
