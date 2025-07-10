<script setup lang="ts">
import { Card, CardContent, CardDescription, CardFooter, CardHeader, CardTitle } from '@/components/ui/card';
import { Separator } from '@/components/ui/separator';
import { ApiCard } from '@/types';

interface Props {
    card: ApiCard;
}
const props = defineProps<Props>();
const imgUrl = 'apiUrl';
</script>

<template>
    <Card>
        <CardHeader>
            <CardTitle>{{ card.name }}</CardTitle>
            <CardDescription class="flex justify-center items-center w-full">
                <span v-if="card.level" class="text-start grow-2">
                    <template v-if="card.frameType === 'xyz'">Rank</template>
                    <template v-else>Level</template>
                    :{{ card.level }}
                </span>
                <span v-if="card.archetype">Arc: {{card.archetype}}</span>
                <span v-if="card.attribute" class="text-end grow-2">{{ card.attribute }}</span>
                <template v-if="card.linkval">
                    <Separator orientation="horizontal" class="mx-1 h-4!" />
                    <span> Linkval: {{ card.linkval }} </span>
                </template>
            </CardDescription>
        </CardHeader>
        <CardContent><img :alt="imgUrl + card.id + '.jpg'" /></CardContent>
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
