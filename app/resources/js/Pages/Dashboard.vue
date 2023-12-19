<script setup>
import MainLayout from "@/Layout/MainLayout.vue";
import DniwaHead from "@/Components/DniwaHead.vue";
import DniwaDashboardDomains from "@/Components/DniwaDashboardDomains.vue"; 
import { useForm, Link } from '@inertiajs/inertia-vue3'; 
import { ref } from 'vue';

let headlineMain = ref('Dashboard');
let headlineSecondary = ref('Add domain');
let linkPreferences = ref('Preferences');
let linkAccount = ref('Account');
</script>
<template>
	<DniwaHead title="Dashboard" />
	<MainLayout>
		<div class="d-flex align-content-end">
			<div>
				<h2 class="m-1" v-text="headlineMain"/>
			</div>
			<div class="align-self-end p-1" style="margin-left:auto;">
				<span class="text text-primary">
					<Link href="/hostname" v-text="headlineSecondary"/>
				</span>
			</div>
			<div class="align-self-end p-1">
				<span class="text text-secondary">
					&#124;
				</span>
			</div>
			<div class="align-self-end p-1">
				<span class="text text-primary">
					<Link href="/preferences" v-text="linkPreferences"/>
				</span>
			</div>
			<div class="align-self-end p-1">
				<span class="text text-secondary">
					&#124;
				</span>
			</div>
			<div class="align-self-end p-1">
				<span class="text text-primary">
					<Link href="/profile" v-text="linkAccount"/>
				</span>
			</div>
		</div>
		<hr class="mt-0"/>
		<DniwaDashboardDomains />
	</MainLayout>
</template>
