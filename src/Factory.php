<?php

namespace LVR\CreditCard;

use LVR\CreditCard\Cards\Jcb;
use LVR\CreditCard\Cards\Mir;
use LVR\CreditCard\Cards\Visa;
use LVR\CreditCard\Cards\Dankort;
use LVR\CreditCard\Cards\Maestro;
use LVR\CreditCard\Cards\UnionPay;
use LVR\CreditCard\Cards\Discovery;
use LVR\CreditCard\Cards\DinersClub;
use LVR\CreditCard\Cards\Mastercard;
use LVR\CreditCard\Cards\VisaElectron;
use LVR\CreditCard\Cards\AmericanExpress;
use LVR\CreditCard\Cards\Forbrugsforeningen;
use LVR\CreditCard\Exceptions\CreditCardException;

class Factory
{
    protected static $available_cards = [
        // Firs debit cards
        Dankort::class,
        Forbrugsforeningen::class,
        Maestro::class,
        VisaElectron::class,
        // Debit cards
        AmericanExpress::class,
        DinersClub::class,
        Discovery::class,
        Jcb::class,
        Mastercard::class,
        UnionPay::class,
        Visa::class,
        Mir::class,
    ];

    /**
     * @param string $card_number
     *
     * @return \LVR\CreditCard\Cards\Card
     * @throws \LVR\CreditCard\Exceptions\CreditCardException
     */
    public static function makeFromNumber(string $card_number)
    {
        return self::determineCardByNumber($card_number);
    }

    /**
     * @param string $card_number
     *
     * @return mixed
     * @throws \LVR\CreditCard\Exceptions\CreditCardException
     */
    protected static function determineCardByNumber(string $card_number)
    {
        foreach (self::$available_cards as $card) {
            if (preg_match($card::$pattern, $card_number)) {
                return new $card($card_number);
            }
        }

        throw new CreditCardException('Card not found.');
    }
}
