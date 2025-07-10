<script setup lang="ts">
interface Props{
    title?:string
}
withDefaults(defineProps<Props>(), {
    title: ""
});
</script>

<template>
<h1 class="text-4xl font-bold">{{title}}</h1>
</template>