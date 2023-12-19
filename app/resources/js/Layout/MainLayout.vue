<script setup>
import {Link, usePage} from '@inertiajs/inertia-vue3';
import {ref, onMounted} from 'vue';

const theme = ref(document.querySelector('html').getAttribute('data-bs-theme'));

function setTheme(theme){
	document.querySelector("html").setAttribute("data-bs-theme", theme);
}

let toggleTheme = () => {
	if(theme.value == "light"){
		theme.value = "dark";
	}
	else if(theme.value == "dark"){
		theme.value = "light";
	}
	setTheme(theme.value);
	localStorage.setItem("theme", theme.value);
};

onMounted(() => {
	if(usePage().props.value.auth.user.theme){
		theme.value = usePage().props.value.auth.user.theme;
	}else if(localStorage.getItem('theme')){
		theme.value = localStorage.getItem('theme');
	}
	setTheme(theme.value);
})
</script>

<template>
	<!-- Begin navigation bar -->
	<nav class="navbar navbar-expand-lg bg-secondary-subtle mb-5">
		<div class="container-md">
			<Link class="navbar-brand" href="/">DNIWA</Link>
			<div class="d-flex justify-content-end">
				<button v-if="!$page.props.auth.user.username" class="btn btn-primary" @click="toggleTheme" id="color-switch" v-text="theme == 'dark' ? 'Light mode' : 'Dark mode'"/>
				<Link href="/logout" as="button" v-else-if="$page.props.auth.user.username" class="btn btn-primary"  id="sign-out" v-text="'Sign out'" method="post"/>
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

