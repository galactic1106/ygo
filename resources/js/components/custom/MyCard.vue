<script setup lang="ts">
import { Card, CardContent, CardDescription, CardFooter, CardHeader, CardTitle } from '@/components/ui/card';
import { HoverCard, HoverCardContent, HoverCardTrigger } from '@/components/ui/hover-card';
import { Separator } from '@/components/ui/separator';
import { getLinkArrows } from '@/composables/useCardProperties';
import { ApiCard } from '@/types';
import { Square } from 'lucide-vue-next';
// ArrowDown,
// ArrowDownLeft,
// ArrowDownRight,
// ArrowLeft,
// ArrowRight,
// ArrowUp,
// ArrowUpLeft,
// ArrowUpRight

interface Props {
    card: ApiCard;
}
const props = defineProps<Props>();

const { hasTopLeft, hasTop, hasTopRight, hasLeft, hasRight, hasBottomLeft, hasBottom, hasBottomRight, cardBackgroundClass } = getLinkArrows(
    props.card,
);
</script>

<template>
    <Card class="flex flex-col">
        <CardHeader class="flex flex-0 shrink-0 flex-col">
            <CardTitle class="flex flex-0">
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
            </CardTitle>

            <CardDescription class="flex w-full flex-0 items-center justify-center">
                <span v-if="card.level" class="shrink-0 grow-2 text-start">
                    <template v-if="card.frameType === 'xyz'">Rank</template>
                    <template v-else>Level</template>
                    : {{ card.level }}
                </span>
                <span v-else-if="card.linkval && card.linkval > 0" class="grow-2 text-start"> Linkval: {{ card.linkval }} </span>

                <template v-if="card.archetype">
                    <Separator orientation="vertical" class="h-full" style="width: 2px" />
                    <span class="mx-2 overflow-hidden text-nowrap text-ellipsis">{{ card.archetype }}</span>
                    <Separator orientation="vertical" class="h-full" style="width: 2px" />
                </template>
                <span v-else style="min-height: 1rem"></span>

                <span v-if="card.attribute" class="shrink-0 grow-2 text-end">{{ card.attribute }}</span>
            </CardDescription>
        </CardHeader>

        <CardContent class="relative mx-6 flex !aspect-square h-[75%] flex-1 items-center justify-center px-0">
            <template v-if="card.linkmarkers">
                <!--
                <ArrowUpLeft v-if="hasTopLeft" class="absolute top-[-5%] left-[-5%] stroke-3 text-red-500" />
                <ArrowUp v-if="hasTop" class="absolute top-[-5%] left-1/2 -translate-x-1/2 stroke-3 text-red-500" />                <ArrowUpRight v-if="hasTopRight" class="absolute top-[-5%] right-[-5%] stroke-3 text-red-500" />

                <ArrowLeft v-if="hasLeft" class="absolute top-1/2 left-[-5%] -translate-y-1/2 stroke-3 text-red-500" />
                <ArrowRight v-if="hasRight" class="absolute top-1/2 right-[-5%] -translate-y-1/2 stroke-3 text-red-500" />

                <ArrowDownLeft v-if="hasBottomLeft" class="absolute bottom-[-5%] left-[-5%] stroke-3 text-red-500" />
                <ArrowDown v-if="hasBottom" class="absolute bottom-[-5%] left-1/2 -translate-x-1/2 stroke-3 text-red-500" />
                <ArrowDownRight v-if="hasBottomRight" class="absolute right-[-5%] bottom-[-5%] stroke-3 text-red-500" />
                -->

                <Square v-if="hasTopLeft" class="absolute top-[-2.5%] left-[-2.5%] h-[20%] w-[20%] text-red-500" stroke-width="3" />
                <Square v-if="hasTop" class="absolute top-[-2.5%] left-1/2 h-[20%] w-[20%] -translate-x-1/2 text-red-500" stroke-width="3" />
                <Square v-if="hasTopRight" class="absolute top-[-2.5%] right-[-2.5%] h-[20%] w-[20%] text-red-500" stroke-width="3" />

                <Square v-if="hasLeft" class="absolute top-1/2 left-[-2.5%] h-[20%] w-[20%] -translate-y-1/2 text-red-500" stroke-width="3" />
                <Square v-if="hasRight" class="absolute top-1/2 right-[-2.5%] h-[20%] w-[20%] -translate-y-1/2 text-red-500" stroke-width="3" />

                <Square v-if="hasBottomLeft" class="absolute bottom-[-2.5%] left-[-2.5%] h-[20%] w-[20%] text-red-500" stroke-width="3" />
                <Square v-if="hasBottom" class="absolute bottom-[-2.5%] left-1/2 h-[20%] w-[20%] -translate-x-1/2 text-red-500" stroke-width="3" />
                <Square v-if="hasBottomRight" class="absolute right-[-2.5%] bottom-[-2.5%] h-[20%] w-[20%] text-red-500" stroke-width="3" />
            </template>
            <template v-if="card.id">
                <img
                    :src="'/yap/img/cropped/' + card.id"
                    alt="Image unavailable"
                    class="relative z-10 aspect-square h-full w-auto rounded-md object-cover object-[center_top]"
                />
            </template>
        </CardContent>

        <CardFooter class="flex w-full flex-0 shrink-0 flex-col">
            <span class="flex w-full overflow-hidden text-nowrap text-ellipsis">
                <template v-if="card.race">{{ card.race + ' ' }} </template>
                <template v-if="card.type">{{ card.type }}</template>
            </span>
            <Separator orientation="horizontal" class="my-1 rounded-2xl" :class="cardBackgroundClass" style="height: 5px" />
            <span class="flex w-full">
                <div v-if="card.atk" class="grow-2 text-start">Atk: {{ card.atk }}</div>
                <div v-if="card.def" class="grow-1 text-end">Def: {{ card.def }}</div>
                <div v-if="!card.atk && !card.def" class="min-h-4"></div>
            </span>
        </CardFooter>
    </Card>
</template>
