<script setup>
let props = defineProps({
	'htmlData': Object,
	'ageHtml': Number
});
</script>

<template>
	<table class="table table-striped mt-5">
		<thead>
			<tr class="text-center">
				<th colspan="4" scope="col">
					<span>Meta tags</span><br/>
					<span class="text-muted" v-text="props.ageHtml == 0 ? 'Updated recently' : 'Updated ' + props.ageHtml + ' minutes ago'"/>
				</th>
			</tr>
			<tr>
				<th class="text-end w-25 pe-3 text-end" scope="col">
					Meta attribute
				</th>
				<th class="text-start w-25 ps-3 text-start" scope="col">
					Attribute value
				</th>
				<th class="text-start w-25 ps-3 text-end" scope="col">
					Meta attribute
				</th>
				<th class="text-start w-25 ps-3 text-start" scope="col">
					Attribute value
				</th>
			</tr>
		</thead>
		<tbody>
			<tr v-for="metaData in props.htmlData">
				<td v-if="metaData.meta_name != ''" class="text-end w-25 pe-3">
					name
				</td>
				<td v-else-if="metaData.meta_property != ''" class="text-end w-25 pe-3">
					property
				</td>
				<td v-else-if="metaData.meta_charset != ''" class="text-end w-25 pe-3">
					charset
				</td>
				<td v-else-if="metaData.http_equiv != ''" class="text-end w-25 pe-3">
					http-equiv
				</td>
				<td v-else-if="metaData.meta_itemprop != ''" class="text-end w-25 pe-3">
					itemprop
				</td>
				<td v-else class="text-end w-25 pe-3">
				</td>
				<td v-if="metaData.meta_name != ''" class="text-start w-25 pe-3">
					{{ metaData.meta_name }}
				</td>
				<td v-else-if="metaData.meta_property != ''" class="text-start w-25 pe-3">
					{{ metaData.meta_property }}
				</td>
				<td v-else-if="metaData.meta_charset != ''" class="text-start w-25 pe-3">
					{{ metaData.meta_charset }}
				</td>
				<td v-else-if="metaData.http_equiv != ''" class="text-start w-25 pe-3">
					{{ metaData.meta_http_equiv }}
				</td>
				<td v-else-if="metaData.meta_itemprop != ''" class="text-start w-25 pe-3">
					{{ metaData.meta_itemprop }}
				</td>
				<td v-if="metaData.meta_content != ''" class="text-end w-25 pe-3">
					content
				</td>
				<td v-else class="text-start w-25 ps-3">
				</td>
				<td v-if="metaData.meta_content" class="text-start w-25 ps-3">
					{{ metaData.meta_content }}
				</td>
				<td v-else class="text-start w-25 ps-3">
				</td>
			</tr>
		</tbody>	
	</table>
</template>
