<section>
	<div class="p-2 mb-4 bg-secondary-subtle border border-secondary-subtle">
		<header>
			<h3 class="">
				{{ __('Theme') }}
			</h3>
			<p class="">
				{{ __("Set your preferred DNIWA theme.") }}
			</p>
		</header>
		<form method="post" action="{{ route('preferences.update') }}" class="">
			@csrf
			@method('patch')
	
			<div class="form-check form-check-inline">
			  <input class="form-check-input" type="radio" name="theme" id="inlineRadio1" value="light" @if ($userSetting->theme == 'light') checked @endif > 
			  <label class="form-check-label" for="inlineRadio1">Light</label>
			</div>
			<div class="form-check form-check-inline">
			  <input class="form-check-input" type="radio" name="theme" id="inlineRadio2" value="dark" @if ($userSetting->theme == 'dark') checked @endif >
			  <label class="form-check-label" for="inlineRadio2">Dark</label>
			</div>

			<div class="mt-4">
				<x-primary-button>{{ __('Save') }}</x-primary-button>
				@if (session('status') === 'preferences-updated')
				<p
					x-data="{ show: true }"
					x-show="show"
					x-transition
					x-init="setTimeout(() => show = false, 2000)"
					class="text-sm text-gray-600"
				>
					{{ __('Saved.') }}
				</p>
				@endif
			</div>
		</form>
	</div>
</section>
