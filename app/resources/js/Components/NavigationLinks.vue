<script setup>
import {Link} from '@inertiajs/vue3';
</script>

<template>
	<div class="collapse navbar-collapse" id="navbarSupportedContent">
		<ul class="navbar-nav me-auto mb-2 mb-lg-0">
			<li class="nav-item">
				<Link class="nav-link active" href="/">Dashboard</Link>
			</li>
			<li class="nav-item">
				<Link class="nav-link active" href="/preferences">Preferences</Link>
			</li>
			<li class="nav-item">
				<Link class="nav-link active" href="/profile">Account</Link>
			</li>
		</ul>
	</div>
</template>
