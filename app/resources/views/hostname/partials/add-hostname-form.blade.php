<section>
	@if (session('status')==='hostname-added')
	<div class="alert alert-success">Added domain: <span class="text text-success-emphasis"><strong>{{session('domain')}}</strong></span></div>
	@endif
	<div class="p-2 mb-4 bg-secondary-subtle border border-secondary-subtle">
		<header>
			<h3 class="mb-4">
				Enter URL (e.g. http://www.example.org)
			</h3>
		</header>
		<form method="post" action="{{ route('hostname.store') }}" id="form-theme">
			@csrf
			@method('put')
			<div class="form-group row">
					<label for="hostname" class="col-sm-1 col-form-label">URL</label>
					<div class="col-sm-11">
						<input type="text" autofocus="autofocus" class="form-control" id="hostname" name="hostname" value="{{ old('hostname', '') }}"> 
						<x-input-error class="text text-danger" :messages="$errors->get('hostname')" />
					</div>
			</div>
			<div class="mt-4">
				<x-primary-button>{{ __('Save') }}</x-primary-button>
			</div>

		</form>
	</div>
</section>
