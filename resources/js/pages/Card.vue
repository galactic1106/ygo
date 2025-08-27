<script setup lang="ts">
import { Separator } from '@/components/ui/separator';
import AppLayout from '@/layouts/AppLayout.vue';
import { ApiCard, BreadcrumbItemType } from '@/types';
import { Head } from '@inertiajs/vue3';

interface Props {
    card: ApiCard;
}
const props = defineProps<Props>();

const title = 'Card: ' + props.card.name;
const breadcrumbs: BreadcrumbItemType[] = [
    {
        title: 'cards',
        href: '/cards',
    },
    {
        title: props.card.name,
        href: '/cards/' + props.card.id,
    },
];
</script>

<template>
    <Head :title="title"></Head>
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex w-full flex-1 flex-row items-center space-x-5">
            <div class="shrink-0 basis-1/4">
                <img :src="'/yap/img/card/' + card.id" alt="Image not found" class="!aspect-[2.25/3.25]" />
            </div>
            <div class="grow-1 basis-3/4">
                <div class="flex flex-col space-y-3">
                    <div class="text-3xl font-bold">
                        {{ card.name }}
                    </div>
                    <Separator orientation="horizontal" class="!h-[2px]" />
                    <div class="text-lg">
                        {{ card.desc }}
                    </div>

                    <Separator orientation="horizontal" class="!h-[2px]" />
                    <div class="flex w-full flex-1 flex-row">
                        <div>
                            <template v-if="card.level">
                                <template v-if="card.frameType === 'xyz'">Rank</template>
                                <template v-else>Level</template>
                                : {{ card.level }}
                            </template>
                            <template v-else-if="card.linkval && card.linkval > 0">Linkval: {{ card.linkval }}</template>
                        </div>

                        <template v-if="card.archetype">
                            <Separator orientation="vertical" class="mx-2 !h-6 !w-[2x]" />
                            <div>Archetype: {{ card.archetype }}</div>
                        </template>
                        <div v-else style="min-height: 1rem"></div>

                        <template v-if="card.attribute">
                            <Separator orientation="vertical" class="mx-2 !h-6 !w-[2px]" />
                            <div class="">{{ card.attribute }}</div>
                        </template>
                        <template v-if="card.type">
                            <Separator orientation="vertical" class="mx-2 !h-6 !w-[2px]" />
                            <div>{{ card.type }}</div>
                        </template>

                        <template v-if="card.atk">
                            <Separator orientation="vertical" class="mx-2 !h-6 !w-[2px]" />
                            <div>Atk: {{ card.atk }}</div>
                        </template>

                        <template v-if="card.def">
                            <Separator orientation="vertical" class="mx-2 !h-6 !w-[2px]" />
                            <div>Def: {{ card.def }}</div>
                        </template>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
