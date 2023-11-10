<section>
	<div class="p-2 mb-4 bg-secondary-subtle border border-secondary-subtle"> 
		<header>
			<h3 class="">
				{{ __('Update Password') }}
			</h3>

			<p class="">
				{{ __('Ensure your account is using a long, random password to stay secure.') }}
			</p>
		</header>

		<form method="post" action="{{ route('password.update') }}" class="">
			@csrf
			@method('put')

			<div class="form-group row">
				<x-input-label for="current_password" :value="__('Current Password')" class="col-sm-2 col-form-label"/>
				<div class="col-sm-4">
					<x-text-input id="current_password" name="current_password" type="password" class="form-control" autocomplete="current-password" />
					<x-input-error :messages="$errors->updatePassword->get('current_password')" class="form-text" />
				</div>	
			</div>

	<div class="form-group row mt-2">
		<x-input-label for="password" :value="__('New Password')" class="col-sm-2 col-form-label"/>
		<div class="col-sm-4">
			<x-text-input id="password" name="password" type="password" class="form-control" autocomplete="new-password" />
	    <x-input-error :messages="$errors->updatePassword->get('password')" class="form-text" />
		</div>
        </div>

	<div class="form-group row mt-2">
		<x-input-label for="password_confirmation" :value="__('Confirm Password')" class="col-sm-2 col-form-label"/>
		<div class="col-sm-4">
			<x-text-input id="password_confirmation" name="password_confirmation" type="password" class="form-control" autocomplete="new-password" />
			<x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="form-text" />
		</div>
	</div>

        <div class="mt-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'password-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
