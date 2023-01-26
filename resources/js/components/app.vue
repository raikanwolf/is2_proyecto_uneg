<script setup>
	import navbar from './navbar.vue';
</script>
<template>
	<div >
		<navbar/>		
	</div>
	<div class="contenido-banner">
            <router-view></router-view> 
    </div>

</template>