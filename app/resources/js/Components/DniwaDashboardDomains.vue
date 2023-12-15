<script setup>
import {useForm} from '@inertiajs/inertia-vue3';

let form = useForm({
});

let submit = (domainId) => {
	form.delete('/'+domainId);
}

</script>

<template>
	<div class="d-flex pt-4 pb-4">
		<h3>
			Domain list
		</h3>
	</div>
	<div v-for="domain in $page.props.domains">
		<form @submit.prevent="submit(domain.id)" id="form-domain-delete" class="mb-2">
			<div class="btn-group d-flex w-100">
				<a :href="'/hostname/' + domain.id" class="btn btn-outline-primary w-75">
					{{ domain.name }}
				</a>
				<button type="submit" class="btn btn-outline-danger w-25">
					Delete
				</button>
			</div>
		</form>
	</div>
</template>
