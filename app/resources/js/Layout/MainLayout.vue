<script setup>
import NavigationLinks from '@/Components/NavigationLinks.vue';
import {Link, usePage} from '@inertiajs/vue3';
import {ref, onMounted} from 'vue';

let props = {
	'auth': usePage().props.auth
};

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
	if(props.auth.user.username){
		theme.value = props.auth.user.theme;
	}else if(localStorage.getItem('theme')){
		theme.value = localStorage.getItem('theme');
	}
	setTheme(theme.value);
});
</script>

<template>
	<!-- Begin navigation bar -->
	<nav class="navbar navbar-expand-md bg-secondary-subtle mb-5">
		<div class="container-md">
			<div class="navbar-brand">DNIWA</div>
			<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<NavigationLinks v-if="props.auth.user.username"/>
			<button v-if="!props.auth.user.username" class="btn btn-primary" @click="toggleTheme" id="color-switch" v-text="theme == 'dark' ? 'Light mode' : 'Dark mode'"/>
			<Link href="/logout" as="button" v-else-if="props.auth.user.username" class="btn btn-primary"  id="sign-out" v-text="'Sign out'" method="post"/>
		</div>
	</nav>
	<!-- End navigation bar -->
	<!-- Start content -->
	<Transition name="page-transition" appear mode="out-in">
		<div class="container-md">
			<slot />
		</div>
	</Transition>
	<!-- End content -->
</template>

<style>
.page-transition-move,
.page-transition-enter-active,
.page-transition-leave-active{
	transition: all 0.25s ease;
}

.page-transition-enter-from,
.page-transition-leave-to{
	opacity: 0;
	transform: translateY(-50px);
}

.page-transition-leave-active{
	position:absolute;
}
</style>
