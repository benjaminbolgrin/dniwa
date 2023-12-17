<script setup>
import MainLayout from '@/Layout/MainLayout.vue';
import DniwaHead from '@/Components/DniwaHead.vue';
import {ref} from 'vue';
import {useForm} from '@inertiajs/inertia-vue3';

let headlineMain = ref('Account settings');
let headlineProfileInfo = ref('Profile information');
let textInfoProfile = ref('Update your account\'s profile information and email address.');
let headlinePassword = ref('Update password');
let textInfoPassword = ref('Ensure your account is using a long random password to stay secure.');
let submitButton = ref('Save');
let labelName = ref('Name');
let labelEmail = ref('Email');
let labelCurrentPassword = ref('Current password');
let labelPassword = ref('New password');
let labelConfirmPassword = ref('Confirm password');

let props = defineProps({
	userName: String,
	userEmail: String,
	status: String
});

let formProfile = useForm({
	name: props.userName,
	email: props.userEmail,
});

let formPassword = useForm({
	current_password: '',
	password: '',
	password_confirmation: ''
});

let submitProfile = () =>{
	formProfile.patch('/profile');
};


let submitPassword = () =>{
	formPassword.put('/password', {
		onSuccess: () => {
			props.status = 'password-updated';
			formPassword.reset();
		}
	});
};
</script>

<template>
	<DniwaHead title="Edit profile"/>
	<MainLayout>
		<h2 class="m-1">
		    {{ headlineMain }}
		</h2>
		<hr class="mt-0"/>
		<section>
			<div v-if="props.status == 'profile-updated'" class="alert alert-success" v-text="'Profile information updated successfully!'"/>
			<div v-else-if="props.status == 'password-updated'" class="alert alert-success" v-text="'Password updated successfully!'"/>
			<div class="p-2 mb-4 bg-secondary-subtle border border-secondary-subtle">
				<header>
					<h3 class="">
						{{ headlineProfileInfo }}
					</h3>
					<p class="">
						{{ textInfoProfile }}
					</p>
				</header>

				<form @submit.prevent="submitProfile" class="">
			
				<div class="form-group row">
					<label for="name" class="col-sm-2 col-form-label">
						{{ labelName }}
					</label>
					<div class="col-sm-4">
						<input v-model="formProfile.name" type="text" class="form-control" required autofocus/>
						<div v-if="formProfile.errors.name" v-text="formProfile.errors.name" class="fs-6 text-danger"></div>
					</div>
				</div>

				<div class="form-group row mt-2">
					<label for="email" class="col-sm-2 col-form-label">
						{{ labelEmail }}
					</label>
					<div class="col-sm-4">
						<input v-model="formProfile.email" type="email" class="form-control" />
						<div v-if="formProfile.errors.email" v-text="formProfile.errors.email" class="fs-6 text-danger"></div>
					</div>
				</div>

				<div class="mt-4">
					<button type="submit" class="btn btn-secondary" :disabled="formProfile.processing">{{ submitButton }}</button>
				</div>
				</form>
			</div>
		</section>
		<section>
			<div class="p-2 mb-4 bg-secondary-subtle border border-secondary-subtle"> 
				<header>
					<h3 class="">
						{{ headlinePassword }}
					</h3>

					<p class="">
						{{ textInfoPassword }}
					</p>
				</header>

				<form @submit.prevent="submitPassword" class="">
					<div class="form-group row">
						<label for="current_password" class="col-sm-2 col-form-label">
							{{ labelCurrentPassword }}
						</label>
						<div class="col-sm-4">
							<input v-model="formPassword.current_password" type="password" class="form-control"/>
							<div v-if="formPassword.errors.current_password" class="fs-6 text-danger" v-text="formPassword.errors.current_password"/>
						</div>	
					</div>

					<div class="form-group row mt-2">
						<label for="password" class="col-sm-2 col-form-label">
							{{ labelPassword }}
						</label>
						<div class="col-sm-4">
							<input v-model="formPassword.password" type="password" class="form-control" />
							<div v-if="formPassword.errors.password" class="fs-6 text-danger" v-text="formPassword.errors.password"/>
						</div>
					</div>

					<div class="form-group row mt-2">
						<label for="password_confirmation" class="col-sm-2 col-form-label">
							{{ labelConfirmPassword }}
						</label>
						<div class="col-sm-4">
							<input v-model="formPassword.password_confirmation" type="password" class="form-control"/>
							<div v-if="formPassword.errors.password_confirmation" class="fs-6 text-danger" v-text="formPassword.errors.password_confirmation"/>
						</div>
					</div>

					<div class="mt-4">
					    <button type="submit" class="btn btn-secondary" :disabled="formPassword.processing">{{ submitButton }}</button>
					</div>
		    		</form>
			</div>
		</section>
	</MainLayout>
</template>
