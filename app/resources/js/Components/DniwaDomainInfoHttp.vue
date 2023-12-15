<script setup>
</script>

<template>
	<table class="table table-striped text-center mt-5">
		<thead>
			<tr>
				<th colspan="2" scope="col">
					Http data
				</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<th scope="row" class="w-50 pe-3 text-end">
					Response code:
				</th>
				<td class="text-right ps-3 text-start">
					{{ $page.props.httpData.response_code }}
				</td>
			</tr>
			<tr>
				<th scope="row" class="w-50 pe-3 text-end">
					Content-Type:
				</th>
				<td class="ps-3 text-start">
					{{ $page.props.httpData.header }}
				</td>
			</tr>
			<tr>
				<th scope="row" class="w-50 pe-3 text-end">
					Title:
				</th>
				<td class="ps-3 text-start">
					{{ $page.props.httpData.title }}
				</td>
			</tr>
				
		</tbody>
	</table>
</template>
