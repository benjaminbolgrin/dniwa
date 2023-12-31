<x-guest-layout>
	@section('pagetitle', 'Sign in - DNIWA')
	<div class="row">
		<div class="col"></div>
		<div class="col">
			<div class="p-4 bg-secondary-subtle border border-secondary-subtle">
				<h1 class="mb-5">Sign in</h1>
				<!-- Session Status -->
				<x-auth-session-status class="mb-4" :status="session('status')" />

				<form method="POST" action="{{ route('login') }}">
					@csrf

					<!-- Email Address -->
					<div class="form-group mb-3">
						<x-input-label for="email" :value="__('Email')" class="form-label"/>
						<x-text-input id="email" class="form-control" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
						<x-input-error :messages="$errors->get('email')" class="form-text" />
					</div>

					<!-- Password -->
					<div class="form-group mb-3">
						<x-input-label for="password" :value="__('Password')" class="form-label" />
						<x-text-input id="password" class="form-control" type="password" name="password" required autocomplete="current-password" />
						<x-input-error :messages="$errors->get('password')" class="form-text" />
					</div>

					<!-- Remember Me -->
					<div class="form-group mb-3">
						<label for="remember_me" class="form-label">
						<input id="remember_me" type="checkbox" class="form-check-input" name="remember">
						<span>{{ __('Remember me') }}</span>
						</label>
					</div>


					<x-primary-button class="btn btn-outline-info">
						{{ __('Sign in') }}
					</x-primary-button>
				</form>
				<div class="d-flex justify-content-center mt-4">
					<span class="text text-secondary">
						<a class="text-secondary" href="{{route('password.request')}}">
							{{__('Forgot your password?')}}
						</a>
					</span>
				</div>
			</div>
			<span class="text text-primary">
				<a href="{{route('register')}}">
					{{ __('Dont have an account yet? Sign up now!') }}
				</a>
			</span>
		</div>
		<div class="col"></div>
	</div>
</x-guest-layout>
