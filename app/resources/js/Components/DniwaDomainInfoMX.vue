<script setup>
</script>

<template>
	<table class="table table-striped text-center mt-5">
		<thead>
			<tr>
				<th scope="col">
					MX records
				</th>
			</tr>
		</thead>
		<tbody>
			<tr v-for="dnsMX in $page.props.dnsMX">
				<td>
					{{ dnsMX.content }}
				</td>
			</tr>
		</tbody>
	</table>
</template>
