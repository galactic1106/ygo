<script setup lang="ts">
import MyCard from '@/components/custom/MyCard.vue';
import PageTitle from '@/components/PageTitle.vue';
import { Alert, AlertTitle } from '@/components/ui/alert';
import { Tabs, TabsContent, TabsList, TabsTrigger } from '@/components/ui/tabs';
import AppLayout from '@/layouts/AppLayout.vue';
import { BreadcrumbItemType, YgoApiResponse } from '@/types';
import { Head } from '@inertiajs/vue3';

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
    <Head :title="title" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="p-5">
            <PageTitle :title="title" class="mb-5" />
            <Tabs defaultValue="monster" orientation="vertical">
                <TabsList class="grid h-fit w-full grid-cols-1 gap-3 p-2 sm:grid-cols-4 md:w-[70%]">
                    <TabsTrigger value="" class="px-0 text-2xl font-bold !text-white !opacity-100 sm:col-span-4" disabled>Latest: </TabsTrigger>
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
                        <template v-else v-for="card in latestMonsters.data" :key="card.id">
                            <div class="">
                                <MyCard :card="card" class="flex !aspect-[2.25/3.25] flex-0 shrink-0" />
                            </div>
                            <!-- <div>
                                <img :src="'/yap/img/card/' + card.id" alt="Image unavailable" class="aspect-[2.25/3.25]" />
                            </div> -->
                        </template>
                    </div>
                </TabsContent>

                <TabsContent value="spells">
                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
                        <Alert variant="destructive" v-if="!latestSpells.data">
                            <AlertTitle> Latest Spells not found </AlertTitle>
                        </Alert>
                        <template v-else v-for="card in latestSpells.data" :key="card.id">
                            <MyCard :card="card" />
                        </template>
                    </div>
                </TabsContent>

                <TabsContent value="traps">
                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
                        <Alert variant="destructive" v-if="!latestTraps.data">
                            <AlertTitle> Latest Traps not found </AlertTitle>
                        </Alert>
                        <template v-else v-for="card in latestTraps.data" :key="card.id">
                            <MyCard :card="card" />
                        </template>
                    </div>
                </TabsContent>

                <TabsContent value="extras">
                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
                        <Alert variant="destructive" v-if="!latestExtra.data">
                            <AlertTitle> Latest Extra not found </AlertTitle>
                        </Alert>
                        <template v-else v-for="card in latestExtra.data" :key="card.id">
                            <MyCard :card="card" />
                        </template>
                    </div>
                </TabsContent>
            </Tabs>
        </div>
    </AppLayout>
</template>
