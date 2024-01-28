<script setup>
import MainLayout from '@/Layout/MainLayout.vue';
import DniwaHead from '@/Components/DniwaHead.vue';
import DniwaDomainInfoA from '@/Components/DniwaDomainInfoA.vue';
import DniwaDomainInfoMX from '@/Components/DniwaDomainInfoMX.vue';
import DniwaDomainInfoHttp from '@/Components/DniwaDomainInfoHttp.vue';
import DniwaDomainInfoHtml from '@/Components/DniwaDomainInfoHtml.vue';
import { computed, ref } from 'vue';

let props = defineProps({
	'domainInfo': {
		'data': {
			'domainName': String,
			'dnsA': [{
				'content': String,
				'hostname': String
			}],
			'dnsMX': [{
				'content': String,
				'hostname': String
			}],
			'httpData': {
				'response_code': Number,
				'header': String,
				'title': String
			},
			'htmlMetaData': [{
				'meta_name': String,
				'meta_content': String,
				'meta_charset': String,
				'meta_http_equiv': String,
				'meta_property': String,
				'meta_itemprop': String
			}],
			'updateAge': [{
				'updateAgeDnsA': Number,
				'updateAgeDnsMx': Number,
				'updateAgeHttp': Number,
				'updateAgeHtml': Number
			}]
		}
	}
});

const secondsA = ref(props.domainInfo.data.updateAge.updateAgeDnsA);
const secondsMX = ref(props.domainInfo.data.updateAge.updateAgeDnsMx);
const secondsHttp = ref(props.domainInfo.data.updateAge.updateAgeHttp);
const secondsHtml = ref(props.domainInfo.data.updateAge.updateAgeHtml);

// calculate update age
setInterval(() =>{
	secondsA.value += 30;
	secondsMX.value += 30;
	secondsHttp.value += 30;
	secondsHtml.value += 30;
	}, 30000);

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
	<DniwaHead :title="'Domain information for ' + props.domainInfo.data.domainName" />
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
				{{ props.domainInfo.data.domainName }}
			</h3>
		</div>
		<DniwaDomainInfoA :ageDNSA="ageDNSA" :dnsA="props.domainInfo.data.dnsA"/>
		<DniwaDomainInfoMX :ageDNSMX="ageDNSMX" :dnsMX="props.domainInfo.data.dnsMX"/>
		<DniwaDomainInfoHttp :ageHttp="ageHttp" :httpData="props.domainInfo.data.httpData"/>
		<DniwaDomainInfoHtml :ageHtml="ageHtml" :htmlData="props.domainInfo.data.htmlMetaData"/>
	</MainLayout>
</template>
