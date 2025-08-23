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
            <Tabs defaultValue="monster" orientation="vertical">
                <TabsList class="h-fit w-full gap-3 p-2 grid grid-cols-1 sm:grid-cols-4 md:w-[70%]">
                    <TabsTrigger value="" class="text-2xl font-bold px-0 sm:col-span-4  !opacity-100 !text-white" disabled>Latest: </TabsTrigger>
                    <TabsTrigger value="monster" class="bg-[#D19B6A] text-xl">Monsters</TabsTrigger>
                    <TabsTrigger value="spells" class="bg-[#1E9C4B] text-xl">Spells</TabsTrigger>
                    <TabsTrigger value="traps" class="bg-[#B85A8A] text-xl">Traps</TabsTrigger>
                    <TabsTrigger value="extras" class="bg-[#3A6DB1] text-xl">Extras</TabsTrigger>
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
