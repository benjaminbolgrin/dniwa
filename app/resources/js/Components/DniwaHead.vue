<script setup>
import { Head } from '@inertiajs/inertia-vue3';

defineProps({
	title: String
});
</script>

<template>
	<Head :title="title ? `${title} - DNIWA` : 'DNIWA'">
		<slot />
	</Head>
</template>
