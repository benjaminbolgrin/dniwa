<x-guest-layout>
	<div class="row"> 	
		<div class="col"></div>
		<div class="col">
			<h1 class="mb-5">Sign up</h1>
			<form method="POST" action="{{ route('register') }}">
				@csrf

			<!-- Name -->
			<div class="mb-3">
				<x-input-label for="name" :value="__('Name')" class="form-label"/>
				<x-text-input id="name" class="form-control" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
				<x-input-error :messages="$errors->get('name')" class="form-text" />
			</div>

			<!-- Email Address -->
			<div class="mb-3">
				<x-input-label for="email" :value="__('Email')" class="form-label"/>
				<x-text-input id="email" class="form-control" type="email" name="email" :value="old('email')" required autocomplete="username" />
				<x-input-error :messages="$errors->get('email')" class="form-text" />
			</div>

			<!-- Password -->
			<div class="mb-3">
				<x-input-label for="password" :value="__('Password')" class="form-label"/>
				<x-text-input id="password" class="form-control" type="password" name="password" required autocomplete="new-password" />

				<x-input-error :messages="$errors->get('password')" class="form-text" />
			</div>

			<!-- Confirm Password -->
			<div class="mb-3">
				<x-input-label for="password_confirmation" :value="__('Confirm Password')" class="form-label"/>

				<x-text-input id="password_confirmation" class="form-control" type="password" name="password_confirmation" required autocomplete="new-password" />

				<x-input-error :messages="$errors->get('password_confirmation')" class="form-text" />
			</div>
			<x-primary-button class="btn btn-primary">
				{{ __('Register') }}
			</x-primary-button>
			</form>
		</div>
		<div class="col"></div>
	</div>
</x-guest-layout>
