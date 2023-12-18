<script setup>
import {Link} from '@inertiajs/inertia-vue3';
import {ref} from 'vue';
const theme = ref(document.querySelector('html').getAttribute('data-bs-theme'));
let toggleTheme = () => {
	if(theme.value == "light"){
		theme.value = "dark";
	}
	else if(theme.value == "dark"){
		theme.value = "light";
	}

	document.querySelector("html").setAttribute("data-bs-theme", theme.value);
	localStorage.setItem("theme", theme.value);
};
</script>

<template>
	<!-- Begin navigation bar -->
	<nav class="navbar navbar-expand-lg bg-secondary-subtle mb-5">
		<div class="container-md">
			<Link class="navbar-brand" href="/">DNIWA</Link>
			<div class="d-flex justify-content-end">
				<button class="btn btn-primary" @click="toggleTheme" id="color-switch" v-text="theme == 'dark' ? 'Light mode' : 'Dark mode'"/>
			</div>
		</div>
	</nav>
	<!-- End navigation bar -->

	<!-- Start content -->
	<div class="container-md"> 
		<slot />
	</div>
	<!-- End content -->
</template>

