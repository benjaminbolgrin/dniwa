<script setup>
import MainLayout from '@/Layout/MainLayout.vue';
import DniwaHead from '@/Components/DniwaHead.vue';
import {ref} from 'vue';
import {useForm} from '@inertiajs/inertia-vue3';

let headlineMain = ref('Preferences');
let headlineSec = ref('Theme');
let infoTextTheme = ref('Set your preferred DNIWA theme.');
let submitButton = ref('Save');
let themeLight = ref('Light');
let themeDark = ref('Dark');

let form = useForm({
	theme: 'light'
});

let submit = () =>{
	form.patch('/preferences');
};
</script>

<template>
	<DniwaHead title="Edit preferences"/>
	<MainLayout>
		<h2 class="m-1">
		    {{ headlineMain }}
		</h2>
		<hr class="mt-0"/>
		<section>
			<div class="p-2 mb-4 bg-secondary-subtle border border-secondary-subtle">
				<header>
					<h3 class="">
						{{ headlineSec }}
					</h3>
					<p class="">
						{{ infoTextTheme }}
					</p>
				</header>
				<form @submit.prevent="submit" id="form-theme">
					<div class="form-check form-check-inline">
						<input class="form-check-input" type="radio" v-model="form.theme" id="inlineRadio1" value="light"> 
						<label class="form-check-label" for="inlineRadio1">{{ themeLight }}</label>
					</div>
					<div class="form-check form-check-inline">
						<input class="form-check-input" type="radio" v-model="form.theme" id="inlineRadio2" value="dark"> 
						<label class="form-check-label" for="inlineRadio2">{{ themeDark }}</label>
					</div>

					<div class="mt-4">
						<button type="submit" class="btn btn-secondary">{{ submitButton }}</button>
					</div>
				</form>
			</div>
		</section>
	</MainLayout>
</template>
