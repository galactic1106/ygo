<script setup lang="ts">
import { getLinkArrows } from '@/composables/useCardProperties';
import AppLayout from '@/layouts/AppLayout.vue';
import { ApiCard, BreadcrumbItemType } from '@/types';
import { Head } from '@inertiajs/vue3';
interface Props {
    card: ApiCard;
}
const props = defineProps<Props>();
const { hasTopLeft, hasTop, hasTopRight, hasLeft, hasRight, hasBottomLeft, hasBottom, hasBottomRight, cardBackgroundClass } = getLinkArrows(
    props.card,
);

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
        <img :src="'/yap/image/card/'+card.id" alt="Image not found">
        {{ card.name }}
        {{ card.desc }}
        <span v-if="card.level" class="grow-2 text-start">
            <template v-if="card.frameType === 'xyz'">Rank</template>
            <template v-else>Level</template>
            : {{ card.level }}
        </span>
        <span v-elif="card.linkval && card.linkval > 0" class="grow-2 text-start"> Linkval: {{ card.linkval }} </span>
        <span v-if="card.archetype">Arc: {{ card.archetype }}</span> <span v-else style="min-height: 1rem"></span>
        <span v-if="card.attribute" class="grow-2 text-end">{{ card.attribute }}</span>
        <template v-if="card.type">{{ card.type }}</template>
        <div v-if="card.atk" class="grow-2 text-start">Atk: {{ card.atk }}</div>
        <div v-if="card.def" class="grow-1 text-end">Def: {{ card.def }}</div>
        <div v-if="!card.atk && !card.def" class="min-h-4"></div>
    </AppLayout>
</template>
