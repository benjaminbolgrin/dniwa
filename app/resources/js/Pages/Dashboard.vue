<template>
	<DniwaHead title="Dashboard" />
	<MainLayout>
		<div class="d-flex align-content-end">
			<div>
				<h2 class="m-1">
					Dashboard
				</h2>
			</div>
			<div class="align-self-end p-1" style="margin-left:auto;">
				<span class="text text-primary">
					<Link href="/hostname">
						Add Domain
					</Link>
				</span>
			</div>
			<div class="align-self-end p-1">
				<span class="text text-secondary">
					&#124;
				</span>
			</div>
			<div class="align-self-end p-1">
				<span class="text text-primary">
					<Link href="/preferences">Preferences</Link>
				</span>
			</div>
			<div class="align-self-end p-1">
				<span class="text text-secondary">
					&#124;
				</span>
			</div>
			<div class="align-self-end p-1">
				<span class="text text-primary">
					<Link href="/profile">Account</Link> 
				</span>
			</div>
		</div>
		<hr class="mt-0"/>
		<DniwaDashboardDomains />
	</MainLayout>
</template>

<script setup>
	import MainLayout from "@/Layout/MainLayout.vue";
	import DniwaHead from "@/Components/DniwaHead.vue";
	import DniwaDashboardDomains from "@/Components/DniwaDashboardDomains.vue"; 
	import { useForm, Link } from '@inertiajs/inertia-vue3'; 

	let form = useForm({
		email: '',
		password: '',
		remember_me: false,
	});
	
	let submit = () => {
		form.post('/signin')
	};
</script>
