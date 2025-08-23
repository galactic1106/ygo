<script setup lang="ts">
import { HoverCard, HoverCardContent, HoverCardTrigger } from '@/components/ui/hover-card';
// import { Separator } from '@/components/ui/separator';
import { ApiCard } from '@/types';
import { ArrowDown, ArrowDownLeft, ArrowDownRight, ArrowLeft, ArrowRight, ArrowUp, ArrowUpLeft, ArrowUpRight } from 'lucide-vue-next';
import { computed } from 'vue';
// import { getCardBackground } from '@/composables/getCardBackground';

interface Props {
    card: ApiCard;
}
const Props = defineProps<Props>();

const hasTopLeft = computed(() => Props.card.linkmarkers?.includes('Top-Left'));
const hasTop = computed(() => Props.card.linkmarkers?.includes('Top'));
const hasTopRight = computed(() => Props.card.linkmarkers?.includes('Top-Right'));
const hasLeft = computed(() => Props.card.linkmarkers?.includes('Left'));
const hasRight = computed(() => Props.card.linkmarkers?.includes('Right'));
const hasBottomLeft = computed(() => Props.card.linkmarkers?.includes('Bottom-Left'));
const hasBottom = computed(() => Props.card.linkmarkers?.includes('Bottom'));
const hasBottomRight = computed(() => Props.card.linkmarkers?.includes('Bottom-Right'));
// const cardBackgroundClass = computed(() => getCardBackground(Props.card.frameType));
</script>

<template>
    <div class="flex flex-row space-x-3">
        <div class="relative flex aspect-square basis-1/4 items-center justify-center">
            <template v-if="card.linkmarkers">
                <!-- Absolutely positioned arrows -->
                <ArrowUpLeft v-if="hasTopLeft" class="absolute top-[-5%] left-[-5%] stroke-3 text-red-500" />
                <ArrowUp v-if="hasTop" class="absolute top-[-5%] left-1/2 -translate-x-1/2 stroke-3 text-red-500" />
                <ArrowUpRight v-if="hasTopRight" class="absolute top-[-5%] right-[-5%] stroke-3 text-red-500" />

                <ArrowLeft v-if="hasLeft" class="absolute top-1/2 left-[-5%] -translate-y-1/2 stroke-3 text-red-500" />
                <ArrowRight v-if="hasRight" class="absolute top-1/2 right-[-5%] -translate-y-1/2 stroke-3 text-red-500" />

                <ArrowDownLeft v-if="hasBottomLeft" class="absolute bottom-[-5%] left-[-5%] stroke-3 text-red-500" />
                <ArrowDown v-if="hasBottom" class="absolute bottom-[-5%] left-1/2 -translate-x-1/2 stroke-3 text-red-500" />
                <ArrowDownRight v-if="hasBottomRight" class="absolute right-[-5%] bottom-[-5%] stroke-3 text-red-500" />
            </template>
            <template v-if="card.id">
                <img
                    :src="'/yap/img/cropped/' + card.id"
                    alt="Image unavailable"
                    class="relative z-10 aspect-square h-full w-auto rounded-md object-cover object-[center_top]"
                />
            </template>
        </div>
        <div class="grid flex-1 grid-cols-12 grid-rows-3 gap-2">
            <div class="col-span-8 row-start-1">
                <HoverCard>
                    <HoverCardTrigger class="overflow-ellipsis whitespace-nowrap">
                        {{ card.name }}
                    </HoverCardTrigger>
                    <HoverCardContent class="w-fit max-w-[50vw]">
                        {{ card.desc }}
                    </HoverCardContent>
                </HoverCard>
            </div>
            <div class="col-span-4 row-start-1 ">
                    <template v-if="card.atk">Atk: {{ card.atk }}</template>
            </div>
            <div class="col-span-8 row-start-2"></div>
            <div class="col-span-4 row-start-2">
            <template v-if="card.def">Def: {{ card.def }}</template>
            </div>
            <!--

                <div class="flex w-full items-center justify-center">
                    <span v-if="card.level" class="grow-2 text-start">
                        <template v-if="card.frameType === 'xyz'">Rank</template>
                        <template v-else>Level</template>
                        : {{ card.level }}
                    </span>
                    <span v-if="card.linkval && card.linkval > 0" class="grow-2 text-start"> Linkval: {{ card.linkval }} </span>
                    <span v-if="card.archetype">Arc: {{ card.archetype }}</span> <span v-else style="min-height: 1rem"></span>
                    <span v-if="card.attribute" class="grow-2 text-end">{{ card.attribute }}</span>
                </div>
            </div>

                    <!-- <span class="flex w-full">
                        <template v-if="card.race">{{ card.race + ' ' }} </template>
                        <template v-if="card.type">{{ card.type }}</template>
                    </span>
                    <Separator orientation="horizontal" class="my-1 rounded-2xl" :class="cardBackgroundClass" style="height: 5px" /> -->

            -->
        </div>
    </div>
</template>
