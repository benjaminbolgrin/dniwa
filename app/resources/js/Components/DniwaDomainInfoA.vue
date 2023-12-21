<script setup>
</script>

<template>
	<table class="table table-striped text-center mt-5">
		<thead>
			<tr>
				<th colspan="2" scope="col">
					A records
				</th>
			</tr>
		</thead>
		<tbody>
			<tr v-for="dnsA in $page.props.dnsA">
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
