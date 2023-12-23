<script setup>
import MainLayout from '@/Layout/MainLayout.vue';
import DniwaHead from '@/Components/DniwaHead.vue';
import {ref, watchEffect} from 'vue';
import {useForm} from '@inertiajs/inertia-vue3';

let props = defineProps({
	auth: Object
});

const headlineMain = 'Preferences';
const headlineSec = 'Theme';
const infoTextTheme = 'Set your preferred DNIWA theme.';
const submitButton = 'Save';
const themeLight = 'Light';
const themeDark = 'Dark';

let themeSuccess = ref(false);

let formTheme = useForm({
	theme: props.auth.user.theme
});

let submit = () =>{
	formTheme.patch('/preferences', {
		onSuccess: ()=> {
			themeSuccess.value = true;
		}
	});
};

watchEffect(() => {
	if(formTheme.theme){
		if(formTheme.theme != document.querySelector('html').getAttribute('data-bs-theme')){
			document.querySelector('html').setAttribute('data-bs-theme', formTheme.theme);
			submit();
		}
	}
});
</script>

<template>
	<DniwaHead title="Edit preferences"/>
	<MainLayout>
		<h2 class="m-1" v-text="headlineMain" />
		<hr class="mt-0"/>
		<section>
			<!-- Success message -->
			<div v-if="themeSuccess" class="alert alert-success" v-text="'Theme preference has been saved.'"/>
			
			<!-- Theme selection -->
			<div class="p-2 mb-4 bg-secondary-subtle border border-secondary-subtle">
				<header>
					<h3 v-text="headlineSec" />
					<p v-text="infoTextTheme" />
				</header>
				<form @submit.prevent="submit" id="form-theme">
					<div class="form-check form-check-inline">
						<input class="form-check-input" type="radio" v-model="formTheme.theme" id="inlineRadio1" value="light" :checked="$page.props.auth.user.theme == 'light'"/> 
						<label class="form-check-label" for="inlineRadio1" v-text="themeLight"/>
					</div>
					<div class="form-check form-check-inline">
						<input class="form-check-input" type="radio" v-model="formTheme.theme" id="inlineRadio2" value="dark" :checked="$page.props.auth.user.theme == 'dark'"/> 
						<label class="form-check-label" for="inlineRadio2" v-text="themeDark"/>
					</div>
				</form>
			</div>
		</section>
	</MainLayout>
</template>
