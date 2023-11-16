<section>
	<div class="p-2 mb-4 bg-secondary-subtle border border-secondary-subtle">
		<header>
		</header>
		<form method="post" action="{{ route('hostname.store') }}" id="form-theme">
			@csrf
			@method('put')
			<div class="form-group row">
					<label for="hostname" class="col-sm-1 col-form-label">Hostname</label>
					<div class="col-sm-11">
						<input type="text" class="form-control" id="hostname" name="hostname"> 
					</div>
			</div>
			<div class="mt-4">
				<x-primary-button>{{ __('Save') }}</x-primary-button>
			</div>

		</form>
	</div>
</section>
