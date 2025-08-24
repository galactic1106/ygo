import { getCardBackground } from '@/composables/getCardBackground';
import { ApiCard } from '@/types';
import { computed } from 'vue';

export function getLinkArrows(card: ApiCard, isListElement = false) {
    const hasTopLeft = computed(() => card.linkmarkers?.includes('Top-Left'));
    const hasTop = computed(() => card.linkmarkers?.includes('Top'));
    const hasTopRight = computed(() => card.linkmarkers?.includes('Top-Right'));
    const hasLeft = computed(() => card.linkmarkers?.includes('Left'));
    const hasRight = computed(() => card.linkmarkers?.includes('Right'));
    const hasBottomLeft = computed(() => card.linkmarkers?.includes('Bottom-Left'));
    const hasBottom = computed(() => card.linkmarkers?.includes('Bottom'));
    const hasBottomRight = computed(() => card.linkmarkers?.includes('Bottom-Right'));

    const cardBackgroundClass = computed(() => getCardBackground(card.frameType, isListElement));

    return {
        hasTopLeft,
        hasTop,
        hasTopRight,
        hasLeft,
        hasRight,
        hasBottomLeft,
        hasBottom,
        hasBottomRight,
        cardBackgroundClass,
    };
}
