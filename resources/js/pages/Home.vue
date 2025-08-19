<script setup lang="ts">
import MyCard from '@/components/MyCard.vue';
import PageTitle from '@/components/PageTitle.vue';
import { Alert, AlertTitle } from '@/components/ui/alert';
import { Tabs, TabsContent, TabsList, TabsTrigger } from '@/components/ui/tabs';
import AppLayout from '@/layouts/AppLayout.vue';
import { BreadcrumbItemType, YgoApiResponse } from '@/types';

interface Props {
    latestMonsters: YgoApiResponse;
    latestSpells: YgoApiResponse;
    latestTraps: YgoApiResponse;
    latestExtra: YgoApiResponse;
    breadcrubs?: BreadcrumbItemType[];
}

const Props = withDefaults(defineProps<Props>(), {
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
            <PageTitle :title="title" class="mb-5" />
            <Tabs defaultValue="monster">
                <TabsList class="p-1">
                    <TabsTrigger value="monster" ><h1 class="mb-1 rounded-xl border bg-amber-700 p-2 text-2xl font-bold">Latest Monsters</h1></TabsTrigger>
                    <TabsTrigger value="spells" ><h1 class="mb-1 rounded-xl border bg-emerald-700 p-2 text-2xl font-bold">Latest Spells</h1></TabsTrigger>
                    <TabsTrigger value="traps" ><h1 class="mb-1 rounded-xl border bg-fuchsia-800 p-2 text-2xl font-bold">Latest Traps</h1></TabsTrigger>
                    <TabsTrigger value="extras" ><h1 class="mb-1 rounded-xl border bg-blue-900 p-2 text-2xl font-bold">Latest Extras</h1></TabsTrigger>
                </TabsList>
                <TabsContent value="monster">
                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
                        <Alert variant="destructive" v-if="!latestMonsters.data">
                            <AlertTitle> Latest Monsters not found </AlertTitle>
                        </Alert>
                        <template v-else v-for="c in latestMonsters.data" :key="c.id">
                            <MyCard :card="c" />
                        </template>
                    </div>
                </TabsContent>
                <TabsContent value="spells">
                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
                        <Alert variant="destructive" v-if="!latestSpells.data">
                            <AlertTitle> Latest Spells not found </AlertTitle>
                        </Alert>
                        <template v-else v-for="c in latestSpells.data" :key="c.id">
                            <MyCard :card="c" />
                        </template>
                    </div> </TabsContent
                ><TabsContent value="traps">
                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
                        <Alert variant="destructive" v-if="!latestTraps.data">
                            <AlertTitle> Latest Traps not found </AlertTitle>
                        </Alert>
                        <template v-else v-for="c in latestTraps.data" :key="c.id">
                            <MyCard :card="c" />
                        </template>
                    </div> </TabsContent
                ><TabsContent value="extras">
                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
                        <Alert variant="destructive" v-if="!latestExtra.data">
                            <AlertTitle> Latest Extra not found </AlertTitle>
                        </Alert>
                        <template v-else v-for="c in latestExtra.data" :key="c.id">
                            <MyCard :card="c" />
                        </template>
                    </div>
                </TabsContent>
            </Tabs>
            
        </div>
    </AppLayout>
</template>
