<section>
	@if (session('status')==='preferences-updated')
	<div class="alert alert-success">{{ __('Preferences saved!') }}</div>
	@endif
	<div class="p-2 mb-4 bg-secondary-subtle border border-secondary-subtle">
		<header>
			<h3 class="">
				{{ __('Theme') }}
			</h3>
			<p class="">
				{{ __("Set your preferred DNIWA theme.") }}
			</p>
		</header>
		<form method="post" action="{{ route('preferences.update') }}" id="form-theme">
			@csrf
			@method('patch')
	
			<div class="form-check form-check-inline">
				@if (!is_null($userSetting))
					<input class="form-check-input" type="radio" name="theme" id="inlineRadio1" value="light" @if ($userSetting->theme == 'light') checked @endif > 
				@else
					<input class="form-check-input" type="radio" name="theme" id="inlineRadio1" value="light" checked> 
				@endif
			<label class="form-check-label" for="inlineRadio1">Light</label>
			</div>
			<div class="form-check form-check-inline">
				@if (!is_null($userSetting))
					<input class="form-check-input" type="radio" name="theme" id="inlineRadio2" value="dark" @if ($userSetting->theme == 'dark') checked @endif > 
				@else
					<input class="form-check-input" type="radio" name="theme" id="inlineRadio2" value="light" checked> 
				@endif
				<label class="form-check-label" for="inlineRadio2">Dark</label>
			</div>

			<div class="mt-4">
				<x-primary-button>{{ __('Save') }}</x-primary-button>
			</div>
		<script>
			var form = document.getElementById("form-theme");
			var themeRadioButtons = document.getElementsByName("theme");
			function addListeners(val){
				val.addEventListener("click", function() {form.submit()});
			}
			themeRadioButtons.forEach(addListeners);
		</script>
		</form>
	</div>
</section>
