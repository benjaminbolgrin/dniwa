<script setup>
import {useForm, Link, usePage} from '@inertiajs/inertia-vue3';
import { ref, computed } from 'vue';

let headlineDomainList = ref('Domain list');
let submitButton = ref('Delete');

let formDomainDelete = useForm({
});

let formSearch = useForm({
	searchString: ''
});

const deletedDomain = ref('');
const deleteStatus = ref(false);
const domainDisabled = ref(false);
const userDomains = ref(usePage().props.value.domains);

const filteredDomains = computed(()=>{
	return formSearch.searchString !== '' ? userDomains.value.filter((t) => t.name.includes(formSearch.searchString)) : userDomains.value;
});

let submit = (domainId, domainName) => {
	if(confirm('Delete '+domainName+' from your domain list?')){
		formDomainDelete.delete('/'+domainId, {
			onSuccess: () =>{
				deletedDomain.value = domainName;
				deleteStatus.value = true;
			}
		});
	}
};
</script>

<template>
	<div class="d-flex justify-content-between">
		<div class="d-flex pt-4 pb-4">
			<h3 v-text="headlineDomainList"/>
		</div>
		<div class="d-flex pt-4 pb-4">
			<input type="text" v-model="formSearch.searchString" class="form-control" placeholder="Search domain list"/>
		</div>
	</div>
	<div v-if="deleteStatus" v-text="deletedDomain + ' has been deleted from your list'" class="alert alert-info"/>
	<div v-for="domain in filteredDomains">
		<form @submit.prevent="submit(domain.id, domain.name)" id="form-domain-delete" class="mb-2">
			<div class="btn-group d-flex w-100">
				<Link :href="'/hostname/' + domain.id" class="btn btn-outline-primary w-75" as="button" v-text="domain.name" @click="domainDisabled = true" :disabled="domainDisabled"/>
				<button type="submit" class="btn btn-outline-danger w-25" v-text="submitButton" :disabled="formDomainDelete.processing || domainDisabled"/>
			</div>
		</form>
	</div>
</template>
