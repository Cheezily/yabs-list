<template>
	<Head title="User Settings" />

	<AuthenticatedLayout>
		<template #header>
			<h2 class="font-semibold text-xl text-gray-800 leading-tight">
				User Settings
			</h2>
		</template>

    <div class="py-12">
      <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
        <h1 class="text-xl mb-2">
          User Settings
        </h1>

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
					<div class="p-6 bg-white border-b border-gray-200">
						<form @submit.prevent="update_details">
							<div class="flex justify-content">
								<label for="name" class="h-8 w-1/3 text-right">Username</label>
								<input id="name" class="h-8 rounded ml-3 w-2/3" type="text" v-model="details_form.name" />
							</div>
							<p class="text-xs italic text-red-500 text-right">{{details_form_errors.name}}</p>
							<div class="mt-4 flex justify-content">
								<label for="email" class="h-8 w-1/3 text-right">Email</label>
								<input id="email" class="h-8 rounded ml-3 w-2/3" type="email" v-model="details_form.email" />
							</div>
							<p class="text-xs italic text-red-500 text-right">{{details_form_errors.email}}</p>

							<div class="flex items-center justify-end mt-4">
								<PrimaryButton class="" :class="{ 'opacity-25': password_form.processing }" :disabled="password_form.processing">
										Save Details
								</PrimaryButton>
							</div>
						</form>
					</div>
				</div>
				
				<div class="mt-6 bg-white overflow-hidden shadow-sm sm:rounded-lg">
					<div class="p-6 bg-white border-b border-gray-200">
						<form @submit.prevent="update_password">
							<div class="mt-4 flex justify-content">
								<label for="password" class="h-8 w-1/3 text-right">Password</label>
								<input id="password" class="h-8 rounded ml-3 w-2/3" type="password" v-model="password_form.password" />
							</div>
							<p class="text-xs italic text-red-500 text-right">{{password_form_errors.password}}</p>
							<div class="mt-4 flex justify-content">
								<label for="password_confirmation" class="h-8 w-1/3 text-right">Confirm Password</label>
								<input id="password_confirmation" class="h-8 rounded ml-3 w-2/3" type="password" v-model="password_form.password_confirmation" />
							</div>

							<div class="flex items-center justify-end mt-4">
								<PrimaryButton class="" :class="{ 'opacity-25': password_form.processing }" :disabled="password_form.processing">
										Update Password
								</PrimaryButton>
							</div>
						</form>
					</div>
				</div>
				
				<div class="mt-6 bg-white overflow-hidden shadow-sm sm:rounded-lg">
					<p class="text-center pt-4">Delete your user profile and all benchmarks that your have submitted</p>
					<div class="flex justify-end pb-6 pr-6 pt-4 bg-white border-b border-gray-200">
						<PrimaryButton v-if="!delete_confirm" class="bg-red-600" @click="delete_confirm = true">
								Delete Profile
						</PrimaryButton>
						<Link v-else :href="route('delete_user')">
							<PrimaryButton class="bg-red-500 hover:bg-red-600" @click="delete_confirm = true">
									Confirm
							</PrimaryButton>
						</Link>
					</div>
				</div>

			</div>
		</div>
	</AuthenticatedLayout>
</template>

<script>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/inertia-vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import axios from 'axios';

export default {
	components: {
		Head,
		Link,
		PrimaryButton
	},
	layout: AuthenticatedLayout,
	props: [
		'user'
	],
	data() {
		return {
			delete_confirm: false,
			name: '',
			email: '',
			password: '',
			password_confirmation: '',
			details_form: {
				name: '',
				email: ''
			},
			details_form_errors: {
				name: '',
				email: ''
			},
			password_form: {
				password: '',
				password_confirmation: ''
			},
			password_form_errors: {
				password: '',
				password_confirmation: ''
			}
		}
	},
	methods: {
		update_details() {
			axios.post(route('update_user_details'), {
				name: this.details_form.name,
				email: this.details_form.email
			})
			.then(res => {
				console.log(res.data)
				this.$page.props.flash.status = res.data.status
				this.$page.props.flash.message = res.data.message
				this.details_form.name = res.data.name
				this.details_form.email = res.data.email
			})
			.catch(err => {
				console.log(err.data)
				if(err.response.data.errors.name) {this.details_form_errors.name = err.response.data.errors.name[0]}
				if(err.response.data.errors.email) {this.details_form_errors.email = err.response.data.errors.email[0]}
			})
		},
		update_password() {
			axios.post(route('update_user_password'), {
				password: this.password_form.password,
				password_confirmation: this.password_form.password_confirmation
			})
			.then(res => {
				console.log(res.data)
				this.$page.props.flash.status = res.data.status
				this.$page.props.flash.message = res.data.message
				this.password_form.password = ''
				this.password_form.password_confirmation = ''
			})
			.catch(err => {
				this.password_form_errors.password = err.response.data.errors.password[0]
			})
		}
	},
	mounted() {
		console.log('User Settings')
		this.details_form.name = this.user.name
		this.details_form.email = this.user.email
	}
}
</script>