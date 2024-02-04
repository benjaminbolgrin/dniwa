<script setup>
</script>

<template>
<Transition name="status-message" mode="out-in">
	<slot></slot>
</Transition>
</template>

<style>
.status-message-move,
.status-message-enter-active{
	transition: all 0.2s ease;
	filter: brightness(100%);
}

.status-message-enter-from{
	opacity: 50%;
	filter: brightness(150%);
}

.status-message-leave-to,
.status-message-leave-active{
	opacity: 0;
	filter: brightness(0%);
}
</style>
