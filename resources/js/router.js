import {createWebHistory, createRouter} from 'vue-router';

import home from './components/app.vue';
import login from './components/login.vue';

const routes=[
	{
		path:'/',
		name:'home',
		component:home
	},
	{
		path:'/login',
		name:'login',
		component:login
	},
];

const router=createRouter({
	history:createWebHistory(),
	routes
})

export default router;