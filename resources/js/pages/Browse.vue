
<script setup lang="ts">
import MyCard from '@/components/custom/MyCard.vue';
import PageTitle from '@/components/PageTitle.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { BreadcrumbItemType} from '@/types';
import { Head } from '@inertiajs/vue3';

const title = 'Cards';
const breadcrumbs: BreadcrumbItemType[] = [
    {
        title: title,
        href: '/cards',
    },
];


</script>

<template>
    <Head :title="title" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="p-5">
            <PageTitle :title="title" class="mb-5" />
        </div>
    </AppLayout>
</template>