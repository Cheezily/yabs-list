<template>
		<Head title="Submit New Benchmark" />

		<AuthenticatedLayout>
				<template #header>
						<h2 class="font-semibold text-xl text-gray-800 leading-tight">
								Submit New Benchmark
						</h2>
				</template>

				<div class="py-12">
						<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
							<h1 class="text-xl mb-2">
								Submit Benchmark
							</h1>

							<Submit
							:user=user
							:virt_types_string=virt_types_string
							>
							</Submit>
						</div>
				</div>
		</AuthenticatedLayout>
</template>


<script>
	import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
	import { Head } from '@inertiajs/inertia-vue3';
	import Submit from '@/Components/Submit.vue'
	
	export default {
			components: {
				Head,
				Submit
			},
			layout: AuthenticatedLayout,
			props: [
					'user',
					'virt_types_string'
			],
			data() {
				return {

				}
			},
			mounted() {
					console.log('Submit New YABS')
			},
	}
</script>
	