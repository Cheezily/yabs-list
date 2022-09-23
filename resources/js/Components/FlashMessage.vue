<template>
	<transition name="slide">
		<div class="flash" 
				:class="{'flash-success': $page.props.flash.status == 'success', 'flash-warning': $page.props.flash.status == 'error'}" 
				v-if="$page.props.flash.message">
				<span class="mr-6">{{ $page.props.flash.message }}</span>
				<font-awesome-icon 
				@click="$page.props.flash.message = null"
				class="message-close-icon"
				:class="{'flash-success-x': $page.props.flash.status == 'success', 'flash-warning-x': $page.props.flash.status == 'error'}" 
				icon="fa-xmark" />
		</div>
	</transition>
</template>

<script>
export default {
	computed: {
		message() {
			return this.$page.props.flash.message
		}
	},
	watch: {
		message() {
			setTimeout(() => {
				this.$page.props.flash.message = null
			}, 4000)
		}
	},
	mounted() {

	}
}
</script>


<style>
	.flash {
			position: fixed;
			bottom: 25px;
			right: 25px;
			background: white;
			text-align: center;
			padding: 8px 12px;
			border: 2px solid #555;
	}
	
	.message-close-icon {
			font-size: 24px;
			margin-bottom: -5px;
	}
	
	.message-close-icon:hover {
			cursor: pointer;
			color: #777;
	}
	
	.flash-success {
			border-color: green;
			color: green;
	}
	
	.flash-success-x {
			color: darkgreen;
	}
	
	.flash-success-x:hover {
			color: rgb(63, 170, 63);
			cursor: pointer;
	}
	
	.flash-warning-x {
			color: darkred;
	}
	
	.flash-warning-x:hover {
			color: red;
			cursor: pointer;
	}
	
	.flash-warning {
			border-color: red;
			color: red;
	}
	
	.slide-enter-active {
			transition: all 0.2s ease-out;
	}
	
	.slide-leave-active {
			transition: all 0.2s cubic-bezier(1, 0.5, 0.8, 1);
	}
	
	.slide-enter-from,
	.slide-leave-to {
			transform: translateX(350px);
	}
	
	</style>