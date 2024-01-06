<script setup>
import MainLayout from '@/Layout/MainLayout.vue';
import DniwaHead from '@/Components/DniwaHead.vue';
import DniwaDashboardDomains from '@/Components/DniwaDashboardDomains.vue'; 
import AddDomainForm from '@/Components/DniwaAddDomain.vue';
import { useForm } from '@inertiajs/vue3'; 
import { ref } from 'vue';

let addDomainSuccess = ref(false);
let addedUrl = ref('');

const headlineMain = 'Dashboard';
</script>

<template>
	<DniwaHead title="Dashboard" />
	<MainLayout>
		<div class="d-flex align-items-end">
			<div>
				<h2 class="m-1" v-text="headlineMain"/>
			</div>
			<div class="align-self-end p-1 pe-0" style="margin-left:auto;">
				<AddDomainForm @add-domain="(val) => {addDomainSuccess = val}" @added-url="(val) => {addedUrl = val}"/>
			</div>
		</div>
		<hr class="mt-0"/>
		<DniwaDashboardDomains :addDomainSuccess="addDomainSuccess" :addedUrl="addedUrl"/>
	</MainLayout>
</template>
