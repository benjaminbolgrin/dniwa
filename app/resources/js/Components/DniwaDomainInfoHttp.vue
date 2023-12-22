<script setup>
let props = defineProps({
	'httpData': Object,
	'ageHttp': Number
});
</script>

<template>
	<table class="table table-striped text-center mt-5">
		<thead>
			<tr>
				<th colspan="2" scope="col">
					<span>Http data</span><br/>
					<span class="text-muted" v-text="props.ageHttp == 0 ? 'Updated recently' : 'Updated ' + props.ageHttp + ' minutes ago'"/>
				</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<th scope="row" class="w-50 pe-3 text-end">
					Response code:
				</th>
				<td class="text-right ps-3 text-start">
					{{ props.httpData.response_code }}
				</td>
			</tr>
			<tr>
				<th scope="row" class="w-50 pe-3 text-end">
					Content-Type:
				</th>
				<td class="ps-3 text-start">
					{{ props.httpData.header }}
				</td>
			</tr>
			<tr>
				<th scope="row" class="w-50 pe-3 text-end">
					Title:
				</th>
				<td class="ps-3 text-start">
					{{ props.httpData.title }}
				</td>
			</tr>
				
		</tbody>
	</table>
</template>
