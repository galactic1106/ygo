<script setup lang="ts">
import { Card, CardContent, CardDescription, CardFooter, CardHeader, CardTitle } from '@/components/ui/card';
import { HoverCard, HoverCardContent, HoverCardTrigger } from '@/components/ui/hover-card';
import { Separator } from '@/components/ui/separator';
import { ApiCard } from '@/types';

interface Props {
    card: ApiCard;
}
const Props = defineProps<Props>();
const imgUrl = 'apiUrl';

function printMarkers(markers: string[]) {
    let res = '';
    markers.forEach((marker: string) => {
        switch (marker) {
            case 'Top-Left':
                res += '';
                break;
            case 'Top':
                res += '';
                break;
            case 'Top-Right':
                res += '';
                break;
            case 'Right':
                res += '';
                break;
            case 'Bottom-Right':
                res += '';
                break;
            case 'Bottom':
                res += `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-5">
                  <path fill-rule="evenodd" d="M10 3a.75.75 0 0 1 .75.75v10.638l3.96-4.158a.75.75 0 1 1 1.08 1.04l-5.25 5.5a.75.75 0 0 1-1.08 0l-5.25-5.5a.75.75 0 1 1 1.08-1.04l3.96 4.158V3.75A.75.75 0 0 1 10 3Z" clip-rule="evenodd" />
                      </svg>`;
                break;
            case 'Bottom-Left':
                res +=  `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-5">
                  <path fill-rule="evenodd" d="M14.78 5.22a.75.75 0 0 0-1.06 0L6.5 12.44V6.75a.75.75 0 0 0-1.5 0v7.5c0 .414.336.75.75.75h7.5a.75.75 0 0 0 0-1.5H7.56l7.22-7.22a.75.75 0 0 0 0-1.06Z" clip-rule="evenodd" />
                </svg>`;
                break;
            case 'Left':
                res += '';
                break;
            default:
                break;
        }
    });
    return res;
}
</script>

<template>
    <Card>
        <CardHeader>
            <CardTitle>
                <HoverCard>
                    <HoverCardTrigger>
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
                    :{{ card.level }}
                </span>
                <span v-else> Linkval: {{ card.linkval }} </span>
                <span v-if="card.archetype">Arc: {{ card.archetype }}</span>
                <span v-if="card.attribute" class="grow-2 text-end">{{ card.attribute }}</span>
            </CardDescription>

            <template v-if="card.linkmarkers" >
                <CardDescription class="flex w-full items-center justify-center">
                    <Separator orientation="horizontal" class="mx-1 block h-4" />
                </CardDescription>
                <CardDescription class="flex w-full items-center justify-center"> {{ printMarkers(card.linkmarkers)}} </CardDescription>
            </template>
        </CardHeader>
        <CardContent><img :src="'/yap/img/cropped/' + card.id" :alt="'/yap/img/cropped/' + card.id" /></CardContent>
        <CardFooter class="flex-col">
            <span>
                <template v-if="card.race">{{ card.race + ' ' }} </template>
                <template v-if="card.type">{{ card.type }}</template>
            </span>
            <Separator orientation="horizontal" class="my-2" />
            <div class="flex w-full">
                <div v-if="card.atk" class="grow-2 text-start">Atk: {{ card.atk }}</div>
                <div v-if="card.def" class="grow-1 text-end">Def: {{ card.def }}</div>
            </div>
            <!--
            -->
        </CardFooter>
    </Card>
</template>
