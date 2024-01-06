<script setup>
import {useForm, Link, usePage} from '@inertiajs/vue3';
import {ref, computed, watch, toRef} from 'vue';

let props = defineProps([
	'addDomainSuccess',
	'addedUrl'
]);

let statusMessage = ref({
	'type': '',
	'message': ''
});

const headlineDomainList = 'Domain list';
const submitButton = 'Delete';

let formDomainDelete = useForm({
});

let formSearch = useForm({
	searchString: ''
});

const domainDisabled = ref(false);
const userDomains = ref(usePage().props.domains);
const copyAddedUrl = toRef(props, 'addedUrl');

const filteredDomains = computed(()=>{
	return formSearch.searchString !== '' ? userDomains.value.filter((t) => t.name.includes(formSearch.searchString)) : userDomains.value;
});

function removeDomain(hostname){
	userDomains.value = userDomains.value.filter((t) => t !== hostname);
}

let submit = (domain) => {
	if(confirm('Delete '+domain.name+' from your domain list?')){
		formDomainDelete.delete('/'+domain.id, {
			onSuccess: () =>{
				statusMessage.value = {'type': 'delete', 'message': domain.name + ' has been deleted from your list'}
				removeDomain(domain);
			}
		});
	}
};

watch(copyAddedUrl, () => {
	statusMessage.value = {'type': 'add', 'message': copyAddedUrl.value + ' has been added to your domain list'}
	userDomains.value = usePage().props.domains;
});
</script>

<template>
	<div class="d-flex justify-content-between">
		<div class="d-flex pt-4 pb-4">
			<h3 v-text="headlineDomainList"/>
		</div>

		<!-- Search bar-->
		<div class="d-flex pt-4 pb-4">
			<input type="text" v-model="formSearch.searchString" class="form-control" placeholder="Search domain list"/>
		</div>

	</div>
	<!-- Status message -->
	<div v-if="statusMessage.message != ''" :class="statusMessage.type == 'delete' ? 'alert alert-info' : 'alert alert-success'" v-text="statusMessage.message"/>
		
	<!-- Domain list -->
	<div v-for="domain in filteredDomains">
		<form @submit.prevent="submit(domain)" id="form-domain-delete" class="mb-2">
			<div class="btn-group d-flex w-100">
				<Link :href="'/hostname/' + domain.id" class="btn btn-outline-primary w-75" :class="formDomainDelete.processing ? 'disabled' : ''" v-text="domain.name" @click="domainDisabled = true"/>
				<button type="submit" class="btn btn-outline-danger w-25" v-text="submitButton" :disabled="formDomainDelete.processing"/>
			</div>
		</form>
	</div>
</template>
