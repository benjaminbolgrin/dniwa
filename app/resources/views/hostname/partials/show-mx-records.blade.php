<table class="table table-striped text-center mt-5">
	<thead>
		<tr>
			<th scope="col">
				{{ __('MX records') }}
			</th>
		</tr>
	</thead>
@if (count($dnsMX) == 0)
	<tbody>
		<tr>
			<td class="text-center">
				{{ __('There are no MX records for the given domain.') }}
			</td>
		</tr>
	</tbody>
</table>
@else
	<tbody>
		@foreach ($dnsMX as $record)
		<tr>
			<td>
				{{$record->content}}
			</td>
		</tr>
		@endforeach
	</tbody>
</table>
@endif
