<?php

namespace ALttP\Rule;

use ALttP\Item;
use ALttP\Rule;

/**
 * A rule is a setting that can apply changes to the game.
 */
class Boss extends Rule
{
    /**
     * The basic rule set
     */

    public function canBeatBoss($world, $bossName, $items)
    {
        switch ($bossName)
        {
            case 'Armos':
                return $items->hasAny(
                    ['Sword', 'Bow', 'Hammer', 'Boomerang', 'RedBoomerang', 'FireRod4', 'IceRod4', 'CaneOfByrna2', 'CaneOfSomaria2'], $world);
            case 'Lanmola':
                return $items->hasAny(['Sword', 'Hammer', 'Bow', 'FireRod', 'IceRod', 'CaneOfByrna', 'CaneOfSomaria'], $world);
            case 'Moldorm':
                return $items->hasAny(['Sword', 'Hammer']);
            case 'Agahnim':
            case 'Agahnim2':
                return $items->hasAny(['Sword', 'Hammer', 'BugCatchingNet']);
            case 'Helmasaur':
                return $items->hasAny(['Bomb', 'Hammer']) && $items->hasAny(['Sword2', 'Bow'], $world);
            case 'Arrghus':
                $canPullArrgi = $items->has('Hookshot');
                $canKillArrghus = $items->hasAny(['Hammer', 'Sword']) ||
                    (($items->canExtendMagic($world, 2) || $items->canShootArrows($world))
                     && $items->hasRod($world));
                return $canPullArrgi && $canKillArrghus;
            case 'Mothula':
                return $items->hasAny(['Sword', 'Hammer', 'FireRod2', 'CaneOfSomaria2', 'CaneOfByrna2']) || $items->canGetGoodBee();
            case 'Blind':
                return $items->hasAny(['Sword', 'Hammer', 'CaneOfSomaria', 'CaneOfByrna']);
            case 'Kholdstare':
                return $items->canMeltThings($world) && $items->hasAny(['Hammer', 'Sword', 'FireRod3']);
            case 'Vitreous':
                return $items->hasAny(['Hammer', 'Sword', 'Bow']);
            case 'Trinexx':
                return $items->hasAll(['FireRod', 'IceRod']) &&
                (
                    $items->hasAny(['Sword3', 'Hammer']) ||
                    ($items->canExtendMagic($world, 2) && $items->hasSword(2)) || 
                    ($items->canExtendMagic($world, 4) && $items->hasSword())
                );
            default:
                return False;
        }
    }

    public function initWorld(&$config) { }

    public function prepareWorld($world, &$advancement_items, &$nice_items_swords, &$nice_items) { }

    public function canEnter($regionName, $items) {
        return True;
    }
}
