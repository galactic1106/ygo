<script setup lang="ts">
import HeadingSmall from '@/components/HeadingSmall.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItemType } from '@/types';
interface Props {
    breadcrubs?: BreadcrumbItemType[];
}

withDefaults(defineProps<Props>(), {
    breadcrubs: () => [],
});
const breadcrumbs: BreadcrumbItemType[] = [
    {
        title: 'Home',
        href: '/',
    },
];
</script>

<template>
    <head title="Home"></head>
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="p-5">
            <HeadingSmall title="Home"></HeadingSmall>
        </div>
    </AppLayout>
</template>
