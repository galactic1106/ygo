<script setup lang="ts">
const props = defineProps<{
    title?: string;
    data: {
        name: string;
        color: string;
        value: any;
    }[];
}>();

// Format currency values if they're numbers
const formatValue = (value: any) => {
    if (typeof value === 'number') {
        return new Intl.NumberFormat('en-US', {
            style: 'currency',
            currency: 'USD',
        }).format(value);
    }
    if (typeof value === 'string' && !isNaN(parseFloat(value))) {
        return new Intl.NumberFormat('en-US', {
            style: 'currency',
            currency: 'USD',
        }).format(parseFloat(value));
    }
    return value;
};

// Format the site/field names to be more readable
const formatSiteName = (name: string) => {
    const siteNames: Record<string, string> = {
        cardmarket_price: 'Card Market',
        tcgplayer_price: 'TCG Player',
        ebay_price: 'eBay',
        amazon_price: 'Amazon',
        coolstuffinc_price: 'CoolStuffInc',
    };
    return siteNames[name] || name;
};
// Filter out zero values since they're not meaningful in a stacked chart
const filteredData = props.data.filter((item) => {
    const numValue = typeof item.value === 'string' ? parseFloat(item.value) : item.value;
    return numValue > 0;
});
</script>

<template>
    <div class="rounded-lg border bg-background p-3 shadow-md">
        <div class="flex flex-wrap items-center gap-4">
            <div v-for="(item, index) in filteredData" :key="item.name" class="flex items-center gap-1.5">
                <div class="h-3 w-3 shrink-0 rounded-[2px]" :style="{ backgroundColor: item.color }"></div>
                <span class="text-sm text-muted-foreground"> {{ formatSiteName(item.name) }}: </span>
                <span class="text-sm font-medium text-foreground">
                    {{ formatValue(item.value) }}
                </span>
                <span v-if="index < filteredData.length - 1" class="text-sm text-muted-foreground"> </span>
            </div>
        </div>
    </div>
</template>
