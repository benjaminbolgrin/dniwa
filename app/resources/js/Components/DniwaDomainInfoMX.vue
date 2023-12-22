<script setup>
let props = defineProps({
	'dnsMX': Object,
	'ageDNSMX': Number
});
</script>

<template>
	<table class="table table-striped text-center mt-5">
		<thead>
			<tr>
				<th scope="col">
					<span>MX records</span><br/>
					<span class="text-muted" v-text="props.ageDNSMX == 0 ? 'Updated recently': 'Updated '+ props.ageDNSMX +' minutes ago'"/>
				</th>
			</tr>
		</thead>
		<tbody>
			<tr v-for="dnsMX in props.dnsMX">
				<td>
					{{ dnsMX.content }}
				</td>
			</tr>
		</tbody>
	</table>
</template>
