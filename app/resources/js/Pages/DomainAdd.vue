<script setup>
import MainLayout from '@/Layout/MainLayout.vue';
import DniwaHead from '@/Components/DniwaHead.vue';
import {ref} from 'vue';
import {useForm} from '@inertiajs/inertia-vue3';

let headlineMain = ref('Add domain name');
let headlineSec = ref('Enter URL (e.g. http://www.example.org)');
let submitButton = ref('Save');
let inputLabelUrl = ref('URL');

let form = useForm({
	hostname: ''
});

let submit = () => {
	form.put('/hostname');
};
</script>

<template>
	<DniwaHead title="Add domain"/>
	<MainLayout>
		<h2 class="m-1">
		    {{ headlineMain }}
		</h2>
		<hr class="mt-0"/>
		<section>
			<div class="p-2 mb-4 bg-secondary-subtle border border-secondary-subtle">
				<header>
					<h3 class="mb-4">
						{{ headlineSec }}
					</h3>
				</header>
				<form @submit.prevent="submit" id="form-theme">
					<div class="form-group row">
						<label for="hostname" class="col-sm-1 col-form-label">{{ inputLabelUrl }}</label>
						<div class="col-sm-11">
							<input type="text" autofocus="autofocus" class="form-control" v-model="form.hostname" /> 
							</div>
					</div>
					<div class="mt-4">
						<button type="submit" class="btn btn-secondary" :disabled="form.processing">{{ submitButton }}</button>
					</div>

				</form>
			</div>
		</section>
	</MainLayout>
</template>
