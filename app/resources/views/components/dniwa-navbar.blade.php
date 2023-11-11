<nav class="navbar navbar-expand-lg bg-secondary-subtle mb-5">
	<div class="container-md">
		<a class="navbar-brand" href="/">DNIWA</a>
		<div class="d-flex justify-content-end">
		
			@guest
			<script>
				function switchText(){
					var theme = document.querySelector("html").getAttribute("data-bs-theme");
					
					if(theme=="dark"){
						theme="light";
					}else if(theme=="light"){
						theme="dark";
					}
					document.getElementById("color-switch").innerHTML=theme+" mode";
				}
				

				function toggleTheme(){
					
					var theme = document.querySelector("html").getAttribute("data-bs-theme");
					
					if(theme == "light"){
						theme = "dark";
					}
					else if(theme == "dark"){
						theme = "light";
					}

					document.querySelector("html").setAttribute("data-bs-theme", theme);
					localStorage.setItem("theme", theme);
					switchText();
				}
			</script>
			<button class="btn btn-primary" onclick="toggleTheme()" id="color-switch">switch color mode</button>
			<script>switchText();</script>
			@endguest
			
			@auth
			<form action="{{route('logout')}}" method="post">
				{{csrf_field()}}
				<input type="submit" class="btn btn-primary" value="{{__('Sign out')}}"></input>
			</form>
			@endauth
		</div>
	</div>
</nav>
