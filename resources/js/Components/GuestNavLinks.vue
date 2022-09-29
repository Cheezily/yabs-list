<template>
	<div class="fixed flex items-top justify-start w-full bg-white top-0 sm:pt-0 h-16 z-20">
		<h1 class="logo ml-3 -mt-1 left">YABSLIST</h1>

		<div class="mt-5 fixed top-0 px-3 py-4">
				<a v-if="$page.props.auth.user" :href="route('dashboard')" 
				class="font-bold text-sm text-orange-500 hover:text-orange-700 underline">Your Dashboard</a>

				<template v-else>
						<a :href="route('login')" 
						class="font-bold text-sm text-orange-500 hover:text-orange-700 underline">Log in</a>

						<a v-if="can_register" :href="route('register')" 
						class="ml-4 font-bold text-sm text-orange-500 hover:text-orange-700 underline">Register</a>

						<a v-if="anon_yabs" :href="route('guest_yabs')"
						class="ml-4 font-bold text-sm text-orange-500 hover:text-orange-700 underline">SUBMIT YABS</a>
				</template>
			</div>
	</div>
</template>

<script>
export default {
	props: [
		'anon_yabs',
		'can_register'
	],
}
</script>

<style scoped>
	.logo {
			position: fixed;
			top: 0;
			left: 0;
	}
	</style>