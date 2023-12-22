<script setup>
let props = defineProps({
	'dnsA': Object,
	'ageDNSA': Number
});
</script>

<template>
	<table class="table table-striped text-center mt-5">
		<thead>
			<tr>
				<th colspan="2" scope="col">
					<span>A records</span><br/>
					<span v-text="props.ageDNSA == 0 ? 'Updated recently' : 'Updated '+props.ageDNSA + ' minutes ago'" class="text-muted"/>
				</th>
			</tr>
		</thead>
		<tbody>
			<tr v-for="dnsA in props.dnsA">
				<td class="w-50 pe-3 text-end">
					{{ dnsA.hostname }}
				</td>
				<td class="ps-3 text-start">
					{{ dnsA.content }}
				</td>
			</tr>
		</tbody>
	</table>
</template>
