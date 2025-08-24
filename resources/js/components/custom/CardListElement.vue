<script setup lang="ts">
import { HoverCard, HoverCardContent, HoverCardTrigger } from '@/components/ui/hover-card';
import { getLinkArrows } from '@/composables/useCardProperties';
import { ApiCard } from '@/types';
import { ArrowDown, ArrowDownLeft, ArrowDownRight, ArrowLeft, ArrowRight, ArrowUp, ArrowUpLeft, ArrowUpRight } from 'lucide-vue-next';

interface Props {
    card: ApiCard;
}
const props = defineProps<Props>();

const { hasTopLeft, hasTop, hasTopRight, hasLeft, hasRight, hasBottomLeft, hasBottom, hasBottomRight, cardBackgroundClass } = getLinkArrows(
    props.card,
    true,
);
</script>

<template>
    <div class="flex flex-row space-x-3">
        <div class="relative flex aspect-square basis-1/4 items-center justify-center">
            <template v-if="card.linkmarkers">
                <!-- Absolutely positioned arrows -->
                <ArrowUpLeft v-if="hasTopLeft" class="absolute top-[-6%] left-[-6%] stroke-3 text-red-500" />
                <ArrowUp v-if="hasTop" class="absolute top-[-7%] left-1/2 -translate-x-1/2 stroke-3 text-red-500" />
                <ArrowUpRight v-if="hasTopRight" class="absolute top-[-6%] right-[-5%] stroke-3 text-red-500" />

                <ArrowLeft v-if="hasLeft" class="absolute top-1/2 left-[-7%] -translate-y-1/2 stroke-3 text-red-500" />
                <ArrowRight v-if="hasRight" class="absolute top-1/2 right-[-7%] -translate-y-1/2 stroke-3 text-red-500" />

                <ArrowDownLeft v-if="hasBottomLeft" class="absolute bottom-[-6%] left-[-6%] stroke-3 text-red-500" />
                <ArrowDown v-if="hasBottom" class="absolute bottom-[-7%] left-1/2 -translate-x-1/2 stroke-3 text-red-500" />
                <ArrowDownRight v-if="hasBottomRight" class="absolute right-[-6%] bottom-[-6%] stroke-3 text-red-500" />
            </template>
            <template v-if="card.id">
                <img
                    :src="'/yap/img/cropped/' + card.id"
                    alt="Image unavailable"
                    class="relative z-10 aspect-square h-full w-auto rounded-md object-cover object-[center_top]"
                />
            </template>
        </div>
        <div class="grid flex-1 grid-flow-col grid-cols-12 grid-rows-4 gap-y-2">
            <div class="col-start-1 col-end-7 row-start-1">
                <HoverCard>
                    <p class="overflow-hidden text-nowrap text-ellipsis">
                        <HoverCardTrigger>
                            {{ card.name }}
                        </HoverCardTrigger>
                    </p>
                    <HoverCardContent class="w-fit max-w-[50vw]">
                        {{ card.name }}
                        <br />
                        {{ card.desc }}
                    </HoverCardContent>
                </HoverCard>
            </div>
            <div class="col-start-8 col-end-11 row-start-1">
                <template v-if="card.level">
                    <template v-if="card.frameType === 'xyz'">Rank</template>
                    <template v-else>Level</template>
                    : {{ card.level }}
                </template>
                <template v-else-if="card.linkval && card.linkval > 0"> Linkval: {{ card.linkval }} </template>
            </div>
            <div class="col-start-12 col-end-12 row-start-1 row-end-5 rounded-3xl text-[rgba(0,0,0,0)]" :class="cardBackgroundClass"></div>

            <div class="col-start-1 col-end-5 row-start-2">
                <template v-if="card.attribute">{{ card.attribute }}</template>
            </div>
            <div class="col-start-6 col-end-11 row-start-2">
                <template v-if="card.archetype">Arc: {{ card.archetype }}</template> <span v-else style="min-height: 1rem"></span>
            </div>

            <div class="col-span-11 row-start-3">
                <template v-if="card.race">{{ card.race + ' ' }} </template>
                <template v-if="card.type">{{ card.type }}</template>
            </div>

            <div class="col-start-1 col-end-5 row-start-4 text-start">
                <template v-if="card.atk">Atk: {{ card.atk }}</template>
            </div>
            <div class="col-start-6 col-end-10 row-start-4 text-end">
                <template v-if="card.def">Def: {{ card.def }}</template>
            </div>
        </div>
    </div>
</template>
