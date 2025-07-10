import type { LucideIcon } from 'lucide-vue-next';
import type { Config } from 'ziggy-js';

export interface Auth {
    user: User;
}

export interface BreadcrumbItem {
    title: string;
    href: string;
}

export interface NavItem {
    title: string;
    href: string;
    icon?: LucideIcon;
    isActive?: boolean;
}

export type AppPageProps<T extends Record<string, unknown> = Record<string, unknown>> = T & {
    name: string;
    quote: { message: string; author: string };
    auth: Auth;
    ziggy: Config & { location: string };
    sidebarOpen: boolean;
};

export interface User {
    id: number;
    name: string;
    email: string;
    avatar?: string;
    email_verified_at: string | null;
    created_at: string;
    updated_at: string;
    phone: string;
}

export type BreadcrumbItemType = BreadcrumbItem;

export interface ApiCard {
    id: number;
    name: string;
    type: string;
    frameType: string;
    desc: string;
    atk?: number; 
    def?: number; 
    level?: number;
    race: string;
    attribute?: string;
    archetype?: string;
    linkval?: number;
    linkmarkers?: string[];
    ygoprodeck_url: string;
    card_sets: CardSet[];
    card_images: {
        id: number;
        image_url: string;
        image_url_small: string;
        image_url_cropped: string;
    }[];
    card_prices: {
        cardmarket_price: string;
        tcgplayer_price: string;
        ebay_price: string;
        amazon_price: string;
        coolstuffinc_price: string;
    }[];
}

export interface Meta {
    current_rows: number;
    total_rows: number;
    rows_remaining: number;
    total_pages: number;
    pages_remaining: number;
    next_page?: string;
    next_page_offset?: number;
}

export interface YgoApiResponse {
    data?: ApiCard[];
    meta?: Meta;
    error?: string; 
}
