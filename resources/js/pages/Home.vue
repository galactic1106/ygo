<script setup lang="ts">
import PageTitle from '@/components/PageTitle.vue';
import { Alert, AlertTitle } from '@/components/ui/alert';
import AppLayout from '@/layouts/AppLayout.vue';
import { BreadcrumbItemType, YgoApiResponse } from '@/types';
import MyCard from '@/components/MyCard.vue';

interface Props {
    latestMonsters: YgoApiResponse;
    latestSpells: YgoApiResponse;
    latestTraps: YgoApiResponse;
    latestExtra: YgoApiResponse;
    breadcrubs?: BreadcrumbItemType[];
};

const props = withDefaults(defineProps<Props>(), {
    breadcrubs: () => [],
    latestMonsters: () => {
        return { data: [] };
    },
    latestSpells: () => {
        return { data: [] };
    },
    latestTraps: () => {
        return { data: [] };
    },
    latestExtra: () => {
        return { data: [] };
    },
});
const title = 'Home';
const breadcrumbs: BreadcrumbItemType[] = [
    {
        title: title,
        href: '/',
    },
];
</script>

<template>
    <head :title="title"></head>
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="p-5">
            <PageTitle :title="title" class="mb-5"/>
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
                <Alert variant="destructive" v-if="!latestMonsters.data">
                    <AlertTitle> Latest Monsters not found </AlertTitle>
                </Alert>
                <template v-else v-for="c in latestMonsters.data" :key="c.id">
                    <MyCard :card="c"/>
                </template>
            </div>
        </div>
    </AppLayout>
</template>
