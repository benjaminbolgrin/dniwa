<script setup>
import MainLayout from '@/Layout/MainLayout.vue';
import DniwaHead from '@/Components/DniwaHead.vue';
import {ref} from 'vue';
import {useForm} from '@inertiajs/vue3';
import DniwaMessageTransition from '@/Components/DniwaMessageTransition.vue'

const headlineMain = 'Account settings';
const headlineProfileInfo = 'Profile information';
const textInfoProfile = 'Update your account\'s profile information and email address.';
const headlinePassword = 'Update password';
const textInfoPassword = 'Ensure your account is using a long random password to stay secure.';
const submitButton = 'Save';
const labelName = 'Name';
const labelEmail = 'Email';
const labelCurrentPassword = 'Current password';
const labelPassword = 'New password';
const labelConfirmPassword = 'Confirm password';

let props = defineProps({
	userName: String,
	userEmail: String,
	status: String
});

const submitProfileToggle = ref(false);
const submitPasswordToggle = ref(false);

let formProfile = useForm({
	name: props.userName,
	email: props.userEmail,
});

let formPassword = useForm({
	current_password: '',
	password: '',
	password_confirmation: ''
});

let submitProfile = ()=>{
	formProfile.patch('/profile',{
	onSuccess: () => {
		submitProfileToggle.value = !submitProfileToggle.value;}});
};


let submitPassword = () =>{
	formPassword.put('/password', {
		onSuccess: () => {
			submitPasswordToggle.value = !submitPasswordToggle.value;
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
			<!-- Success messages -->
			<DniwaMessageTransition>	
				<div v-if="props.status == 'profile-updated'" class="alert alert-success" v-text="'Profile information updated successfully!'" :key="submitProfileToggle"/>
				<div v-else-if="props.status == 'password-updated'" class="alert alert-success" v-text="'Password updated successfully!'" :key="submitPasswordToggle"/>
			</DniwaMessageTransition>
			
			<!-- Profile form -->
			<div class="p-2 mb-4 bg-secondary-subtle border border-secondary-subtle">
				<header>
					<h3 v-text="headlineProfileInfo" />
					<p v-text="textInfoProfile" />
				</header>

				<form @submit.prevent="submitProfile">
				
					<!-- Name -->	
					<div class="form-group row">
						<label for="name" class="col-sm-2 col-form-label" v-text=labelName />
						<div class="col-sm-4">
							<input v-model="formProfile.name" type="text" class="form-control" required autofocus/>
							<div v-if="formProfile.errors.name" v-text="formProfile.errors.name" class="text-danger" />
						</div>
					</div>

					<!-- Email -->
					<div class="form-group row mt-2">
						<label for="email" class="col-sm-2 col-form-label" v-text="labelEmail" />
						<div class="col-sm-4">
							<input v-model="formProfile.email" type="email" class="form-control" />
							<div v-if="formProfile.errors.email" v-text="formProfile.errors.email" class="text-danger" />
						</div>
					</div>

					<!-- Submit button -->
					<div class="mt-4">
						<button type="submit" class="btn btn-secondary" :disabled="formProfile.processing" v-text="submitButton" />
					</div>
				</form>
			</div>
		</section>
		<section>

			<!-- Password form -->
			<div class="p-2 mb-4 bg-secondary-subtle border border-secondary-subtle"> 
				<header>
					<h3 v-text="headlinePassword" />
					<p v-text="textInfoPassword" />
				</header>

				<form @submit.prevent="submitPassword">

					<!-- Current password -->
					<div class="form-group row">
						<label for="current_password" class="col-sm-2 col-form-label" v-text="labelCurrentPassword" />
						<div class="col-sm-4">
							<input v-model="formPassword.current_password" type="password" class="form-control"/>
							<div v-if="formPassword.errors.current_password" class="text-danger" v-text="formPassword.errors.current_password"/>
						</div>	
					</div>
					
					<!-- New password -->
					<div class="form-group row mt-2">
						<label for="password" class="col-sm-2 col-form-label" v-text="labelPassword" />
						<div class="col-sm-4">
							<input v-model="formPassword.password" type="password" class="form-control" />
							<div v-if="formPassword.errors.password" class="text-danger" v-text="formPassword.errors.password"/>
						</div>
					</div>
					
					<!-- Confirm new password -->
					<div class="form-group row mt-2">
						<label for="password_confirmation" class="col-sm-2 col-form-label" v-text="labelConfirmPassword" />
						<div class="col-sm-4">
							<input v-model="formPassword.password_confirmation" type="password" class="form-control"/>
							<div v-if="formPassword.errors.password_confirmation" class="text-danger" v-text="formPassword.errors.password_confirmation"/>
						</div>
					</div>
					
					<!-- Submit button -->
					<div class="mt-4">
					    <button type="submit" class="btn btn-secondary" :disabled="formPassword.processing" v-text="submitButton" />
					</div>
		    		</form>
			</div>
		</section>
	</MainLayout>
</template>
