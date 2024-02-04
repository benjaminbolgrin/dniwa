<script setup>
import {Link} from '@inertiajs/vue3';

let url = window.location.pathname;
</script>

<template>
	<div class="collapse navbar-collapse" id="navbarSupportedContent">
		<ul class="navbar-nav me-auto mb-2 mb-lg-0">
			<li class="nav-item">
				<Link :class="(url === '/') ? 'nav-link active': 'nav-link'" href="/">Dashboard</Link>
			</li>
			<li class="nav-item">
				<Link :class="(url === '/preferences') ? 'nav-link active' : 'nav-link'" href="/preferences">Preferences</Link>
			</li>
			<li class="nav-item">
				<Link :class="(url === '/profile') ? 'nav-link active' : 'nav-link'" href="/profile">Account</Link>
			</li>
		</ul>
	</div>
</template>
