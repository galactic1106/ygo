<script setup lang="ts">
import { Card, CardContent, CardDescription, CardFooter, CardHeader, CardTitle } from '@/components/ui/card';
import { HoverCard, HoverCardContent, HoverCardTrigger } from '@/components/ui/hover-card';
import { Separator } from '@/components/ui/separator';
import { ApiCard } from '@/types';
import { ArrowDown, ArrowDownLeft, ArrowDownRight, ArrowLeft, ArrowRight, ArrowUp, ArrowUpLeft, ArrowUpRight } from 'lucide-vue-next';
import { computed } from 'vue';

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

// Computed property for background color classes (solid colors)
const cardBackgroundClass = computed(() => {
    switch (Props.card.frameType) {
        case 'normal':
            return 'bg-[#F8D37A]'; // Normal Monster
        case 'effect':
            return 'bg-[#D19B6A]'; // Effect Monster
        case 'ritual':
            return 'bg-[#6DC3E6]'; // Ritual Monster
        case 'fusion':
            return 'bg-[#A97EDB]'; // Fusion Monster
        case 'synchro':
            return 'bg-[#EDEDED]'; // Synchro Monster
        case 'xyz':
            return 'bg-[#222222]'; // Xyz Monster
        case 'link':
            return 'bg-[#3A6DB1]'; // Link Monster
        case 'spell':
            return 'bg-[#1E9C4B]'; // Spell Card
        case 'trap':
            return 'bg-[#B85A8A]'; // Trap Card
        case 'token':
            return 'bg-[#EDEDED]'; // Token (use Synchro color)
        case 'skill':
            return 'bg-[#6DC3E6]'; // Skill Card (use Ritual color)
        case 'normal_pendulum':
            return 'bg-[linear-gradient(to_right,#F8D37A_0%,#1E9C4B_100%)]';
        case 'effect_pendulum':
            return 'bg-[linear-gradient(to_right,#D19B6A_0%,#1E9C4B_100%)]';
        case 'fusion_pendulum':
            return 'bg-[linear-gradient(to_right,#A97EDB_0%,#1E9C4B_100%)]';
        case 'synchro_pendulum':
            return 'bg-[linear-gradient(to_right,#EDEDED_0%,#1E9C4B_100%)]';
        case 'xyz_pendulum':
            return 'bg-[linear-gradient(to_right,#222222_0%,#1E9C4B_100%)]';
        case 'ritual_pendulum':
            return 'bg-[linear-gradient(to_right,#6DC3E6_0%,#1E9C4B_100%)]';
        default:
            return '';
    }
});
</script>

<template>
    <div class="!aspect-[2.25/3.25]">
        <Card class="flex h-full w-full flex-col">
            <CardHeader>
                <CardTitle>
                    <HoverCard>
                        <HoverCardTrigger class="overflow-ellipsis whitespace-nowrap">
                            {{ card.name }}
                        </HoverCardTrigger>
                        <HoverCardContent class="w-fit max-w-[50vw]">
                            {{ card.desc }}
                        </HoverCardContent>
                    </HoverCard>
                </CardTitle>

                <CardDescription class="flex w-full items-center justify-center">
                    <span v-if="card.level" class="grow-2 text-start">
                        <template v-if="card.frameType === 'xyz'">Rank</template>
                        <template v-else>Level</template>
                        : {{ card.level }}
                    </span>
                    <span v-if="card.linkval && card.linkval > 0" class="grow-2 text-start"> Linkval: {{ card.linkval }} </span>
                    <span v-if="card.archetype">Arc: {{ card.archetype }}</span> <span v-else style="min-height: 1rem"></span>
                    <span v-if="card.attribute" class="grow-2 text-end">{{ card.attribute }}</span>
                </CardDescription>
            </CardHeader>

            <CardContent class="relative mx-6 flex flex-1 items-center justify-center px-0 h-[75%]">
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
            </CardContent>

            <CardFooter class="flex-col">
                <span class="flex w-full">
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
    </div>
</template>
