<script setup>
import {ref} from 'vue';
import {useForm} from '@inertiajs/vue3';

const emit = defineEmits(['addDomain',]);

const submitButton = 'Add';
const addDomainSuccess = ref(false);
const addedHostname = ref('');

let formAddHostname = useForm({
	hostname: ''
});

let submit = () => {
	formAddHostname.put('/hostname', {
		onSuccess: () => {
			addedHostname.value = formAddHostname.hostname;
			addDomainSuccess.value = true;
			emit('addedUrl', addedHostname.value);
			emit('addDomain', true);
			formAddHostname.reset();
		}
	});
};
</script>

<template>
	<AddDomainForm>
		<form @submit.prevent="submit" id="form-theme">
			<div class="row">
				<div class="col-auto">
					<div>&nbsp;</div>
					<label for="formAddHostname.hostname" v-text="'Add domain:'" class="col-form-label"/>
				</div>
				<div class="col-auto ps-0">
				<div v-if="formAddHostname.errors.hostname" v-text="formAddHostname.errors.hostname" class="text-danger"/>
				<div v-else v-text="'&nbsp;'"/>
					<div class="input-group w-auto">
						<input type="text" id="formAddHostname.hostname" class="form-control" v-model="formAddHostname.hostname" placeholder="http://example.com"/> 
						<button type="submit" class="btn btn-secondary" :disabled="formAddHostname.processing" v-text="submitButton" />
					</div>
				</div>
			</div>
		</form>
	</AddDomainForm>
</template>
