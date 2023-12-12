<template>
	<main>
		<header>
			<Link href="/">Home</Link>
			<Link href="/signin">Signin</Link>
		</header>
		<article>
			<slot />
		</article>
	</main>
</template>

<script setup>
	import {Link} from '@inertiajs/inertia-vue3'

	defineProps({})
</script>
