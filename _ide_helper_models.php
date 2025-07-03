<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * 
 *
 * @property string $id
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Deck> $decks
 * @property-read int|null $decks_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Offer> $offers
 * @property-read int|null $offers_count
 * @method static \Database\Factories\CardFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Card newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Card newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Card query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Card whereId($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperCard {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $card_id
 * @property int $deck_id
 * @property int $quantity
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CardDeck newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CardDeck newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CardDeck query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CardDeck whereCardId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CardDeck whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CardDeck whereDeckId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CardDeck whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CardDeck whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CardDeck whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperCardDeck {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $cvv
 * @property string $number
 * @property string $expiration
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $order_id
 * @property-read \App\Models\Order|null $order
 * @method static \Database\Factories\CreditCardFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CreditCard newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CreditCard newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CreditCard query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CreditCard whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CreditCard whereCvv($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CreditCard whereExpiration($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CreditCard whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CreditCard whereNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CreditCard whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CreditCard whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperCreditCard {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $name
 * @property string|null $notes
 * @property int $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Card> $cards
 * @property-read int|null $cards_count
 * @property-read \App\Models\User $user
 * @method static \Database\Factories\DeckFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Deck newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Deck newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Deck query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Deck whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Deck whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Deck whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Deck whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Deck whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Deck whereUserId($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperDeck {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $quality
 * @property string $description
 * @property float $price
 * @property int $quantity
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $card_id
 * @property int $user_id
 * @property-read \App\Models\Card $card
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\OldPrice> $oldPrices
 * @property-read int|null $old_prices_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\OldQuantity> $oldQuantities
 * @property-read int|null $old_quantities_count
 * @property-read \App\Models\User $user
 * @method static \Database\Factories\OfferFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Offer newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Offer newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Offer query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Offer whereCardId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Offer whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Offer whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Offer whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Offer wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Offer whereQuality($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Offer whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Offer whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Offer whereUserId($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperOffer {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $order_id
 * @property int $offer_id
 * @property int $quantity
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OfferOrder newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OfferOrder newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OfferOrder query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OfferOrder whereOfferId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OfferOrder whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OfferOrder whereQuantity($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperOfferOrder {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property float $old_price
 * @property string|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $offer_id
 * @property-read \App\Models\Offer $offer
 * @method static \Database\Factories\OldPriceFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OldPrice newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OldPrice newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OldPrice query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OldPrice whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OldPrice whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OldPrice whereOfferId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OldPrice whereOldPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OldPrice whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperOldPrice {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $old_quantity
 * @property string|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $offer_id
 * @property-read \App\Models\Offer $offer
 * @method static \Database\Factories\OldQuantityFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OldQuantity newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OldQuantity newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OldQuantity query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OldQuantity whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OldQuantity whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OldQuantity whereOfferId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OldQuantity whereOldQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OldQuantity whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperOldQuantity {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $state
 * @property string|null $country
 * @property string|null $city
 * @property string|null $street
 * @property int|null $house_number
 * @property string|null $zip_code
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $user_id
 * @property-read \App\Models\CreditCard|null $creditCard
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Offer> $offers
 * @property-read int|null $offers_count
 * @property-read \App\Models\User $user
 * @method static \Database\Factories\OrderFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereHouseNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereStreet($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereZipCode($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperOrder {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string|null $phone
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Deck> $decks
 * @property-read int|null $decks_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Offer> $offers
 * @property-read int|null $offers_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperUser {}
}

