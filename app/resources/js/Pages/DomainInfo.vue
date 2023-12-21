<script setup>
import MainLayout from "@/Layout/MainLayout.vue";
import DniwaHead from "@/Components/DniwaHead.vue";
import DniwaDomainInfoA from '@/Components/DniwaDomainInfoA.vue';
import DniwaDomainInfoMX from '@/Components/DniwaDomainInfoMX.vue';
import DniwaDomainInfoHttp from '@/Components/DniwaDomainInfoHttp.vue';
import DniwaDomainInfoHtml from '@/Components/DniwaDomainInfoHtml.vue';
import { Link } from '@inertiajs/inertia-vue3'; 
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
		<DniwaDomainInfoA />
		<DniwaDomainInfoMX />
		<DniwaDomainInfoHttp />
		<DniwaDomainInfoHtml />
	</MainLayout>
</template>
