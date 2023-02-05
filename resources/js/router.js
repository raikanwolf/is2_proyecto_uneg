import {createWebHistory, createRouter} from 'vue-router';

import home from './App.vue';

const routes=[
	{
		path:'/',
		name:'home',
		component:home
	},

];

const router=createRouter({
	history:createWebHistory(),
	routes
})

export default router;