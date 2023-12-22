<script setup>
import MainLayout from "@/Layout/MainLayout.vue";
import DniwaHead from "@/Components/DniwaHead.vue";
import DniwaDomainInfoA from '@/Components/DniwaDomainInfoA.vue';
import DniwaDomainInfoMX from '@/Components/DniwaDomainInfoMX.vue';
import DniwaDomainInfoHttp from '@/Components/DniwaDomainInfoHttp.vue';
import DniwaDomainInfoHtml from '@/Components/DniwaDomainInfoHtml.vue';
import { Link, usePage } from '@inertiajs/inertia-vue3'; 
import { computed, ref } from 'vue';

let props = defineProps({
	'dnsA': Object,
	'dnsMX': Object,
	'httpData': Object,
	'htmlData': Object,
	'updateAge': Object
});

// calculate update age
let secondsA = ref(usePage().props.value.updateAge.a);
let secondsMX = ref(usePage().props.value.updateAge.mx);
let secondsHttp = ref(usePage().props.value.updateAge.http);
let secondsHtml = ref(usePage().props.value.updateAge.html);

setInterval(() =>{
	secondsA.value += 60;
	secondsMX.value += 60;
	secondsHttp.value += 60;
	secondsHtml.value += 60;
	}, 60000);

let ageDNSA = computed(()=>{
	return Math.floor(secondsA.value / 60);
});

let ageDNSMX = computed(()=>{
	return Math.floor(secondsMX.value / 60);
});

let ageHttp = computed(()=>{
	return Math.floor(secondsHttp.value / 60);
});

let ageHtml = computed(()=>{
	return Math.floor(secondsHtml.value / 60);
});


</script>
<template>
	<DniwaHead :title="'Domain information for ' + $page.props.domainName" />
	<MainLayout>
		<div class="d-flex align-content-end">
			<div>
				<h2 class="m-1">
					Domain information
				</h2>
			</div>
		</div>
		<hr class="mt-0"/>
		<div class="d-flex justify-content-center">
			<h3 class="m-4">
				{{ $page.props.domainName }}
			</h3>
		</div>
		<DniwaDomainInfoA :ageDNSA="ageDNSA" :dnsA="props.dnsA"/>
		<DniwaDomainInfoMX :ageDNSMX="ageDNSMX" :dnsMX="props.dnsMX"/>
		<DniwaDomainInfoHttp :ageHttp="ageHttp" :httpData="props.httpData"/>
		<DniwaDomainInfoHtml :ageHtml="ageHtml" :htmlData="props.htmlData"/>
	</MainLayout>
</template>
