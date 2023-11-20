<section>
	@if (session('status')==='profile-updated')
	<div class="alert alert-success">{{ __('Profile information updated') }}</div>
	@endif
	<div class="p-2 mb-4 bg-secondary-subtle border border-secondary-subtle">
		<header>
			<h3 class="">
				{{ __('Profile Information') }}
			</h3>
			<p class="">
				{{ __("Update your account's profile information and email address.") }}
			</p>
		</header>

		<form id="send-verification" method="post" action="{{ route('verification.send') }}">
			@csrf
		</form>
	
		<form method="post" action="{{ route('profile.update') }}" class="">
			@csrf
			@method('patch')
	
		<div class="form-group row">
			<x-input-label for="name" :value="__('Name')" class="col-sm-2 col-form-label"/>
			<div class="col-sm-4">
			<x-text-input id="name" name="name" type="text" class="form-control" :value="old('name', $user->name)" required autofocus autocomplete="name" />
			<x-input-error class="form-text" :messages="$errors->get('name')" />
			</div>
		</div>

		<div class="form-group row mt-2">
			<x-input-label for="email" :value="__('Email')" class="col-sm-2 col-form-label"/>
			<div class="col-sm-4">
			<x-text-input id="email" name="email" type="email" class="form-control" :value="old('email', $user->email)" required autocomplete="username" />
			<x-input-error class="form-text" :messages="$errors->get('email')" />
			</div>
			@if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
			<div>
				<p class="text-sm mt-2 text-gray-800">
					{{ __('Your email address is unverified.') }}
					<button form="send-verification" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
					{{ __('Click here to re-send the verification email.') }}
					</button>
				</p>

				@if (session('status') === 'verification-link-sent')
				<p class="mt-2 font-medium text-sm text-green-600">
					{{ __('A new verification link has been sent to your email address.') }}
				</p>
				@endif
			</div>
			@endif
		</div>

		<div class="mt-4">
			<x-primary-button>{{ __('Save') }}</x-primary-button>
		</div>
		</form>
	</div>
</section>
