<template>
	<!--MENU ENCABEZADO-->
	<div class="contenedor-header">
		<header><!--contenedor de logo-->


			<div class="logo">
				<router-link to="/">UNEG</router-link>
			</div>
			<nav id="nav">
				<ul>
					<li><router-link to="/login">login</router-link></li>
				</ul>
			</nav>

			<div class="nav-responsive">
				<i class="fa-solid fa-bars"></i>
			</div>
		</header>
	</div>

</template>