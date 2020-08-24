<?php

namespace ALttP;

/**
 * A rule is a setting that can apply changes to the game.
 */
abstract class Rule
{

    public function canBeatBoss($world, $bossName, $items)
    {
        switch ($bossName)
        {
            case 'Armos':
                // return $items->has('Hammer') || $items->canShootArrows($world)
                //     || $items->has('Boomerang') || $items->has('RedBoomerang')
                //     || ($items->canExtendMagic(4) && ($items->has('FireRod') || $items->has('IceRod')))
                //     || ($items->canExtendMagic(2) && ($items->has('CaneOfByrna') || $items->has('CaneOfSomaria')));
                return $items->hasAny(['Bow', 'Hammer', 'RedBoomerang', 'Boomerang'], $world) ||
                    $items->hasRod(4) ||
                    $items->hasCane(2);
            case 'Lanmola':
                return $items->hasAny(['Hammer', 'Bow', 'FireRod', 'IceRod', 'CaneOfByrna', 'CaneOfSomaria'], $world);
                // return $items->has('Hammer')
                //     || $items->canShootArrows($world) || $items->has('FireRod') || $items->has('IceRod')
                //     || $items->has('CaneOfByrna') || $items->has('CaneOfSomaria');
            case 'Moldorm':
                return $items->has('Hammer');
            case 'Agahnim':
            case 'Agahnim2':
                return $items->hasAny(['Hammer', 'BugCatchingNet']);
                // return $items->has('Hammer') || $items->has('BugCatchingNet');
            case 'Helmasaur':
                return $items->hasAny(['Hammer', 'Bomb'], $world) && $items->canShootArrows($world);
                // return ($items->canBombThings() || $items->has('Hammer')) && $items->canShootArrows($world);
            case 'Arrghus':
                $canGetArrgi = $items->has('Hookshot');
                $canKillArrgi = $items->has('Hammer') 
                    || $items->hasRod(2)
                    || ($items->canShootArrows($world) && $items->hasRod());
                return $canGetArrgi && $canKillArrgi;
                // $canGetArrgi = $items->has('Hookshot');
                // $canKillArrgi = $items->has('Hammer') 
                //     || (($items->canExtendMagic(2) || $items->canShootArrows($world)) 
                //         && ($items->has('FireRod') || $items->has('IceRod')));
                // return $canGetArrgi && $canKillArrgi;
            case 'Mothula':
                return 
                (
                    $world->config('itemPlacement') !== 'basic' || 
                    $items->hasEnoughMagic("FireRod", 2)
                ) && 
                (
                    $items->has('Hammer') || 
                    $items->hasEnoughMagic("FireRod", 2) ||
                    $items->hasCane(2) ||
                    $items->canGetGoodBee()
                );
                // return 
                // (
                //     $world->config('itemPlacement') !== 'basic' || 
                //     (
                //         $items->canExtendMagic(2) && 
                //         $items->has('FireRod')
                //     )
                // ) && 
                // (
                //     $items->has('Hammer') || 
                //     (
                //         $items->canExtendMagic(2) && 
                //         (
                //             $items->has('FireRod') || 
                //             $items->has('CaneOfSomaria') || 
                //             $items->has('CaneOfByrna')
                //         )
                //     ) || 
                //     $items->canGetGoodBee()
                // );
            case 'Blind':
                return $items->hasCane() || $items->has('Hammer');
                // return $items->has('Hammer') || $items->has('CaneOfSomaria') || $items->has('CaneOfByrna');
            case 'Kholdstare':
                $hasMagicAttacks = ($items->hasEnoughMagic("FireRod", 3)) 
                    || ($items->hasEnoughMagic("FireRod", 2) && $items->hasEnoughMagic("Bombos", 2));

                return ($world->config('itemPlacement') !== 'basic' || $hasMagicAttacks) 
                    && $items->canMeltThings($world) 
                    && ($items->has('Hammer') || $hasMagicAttacks);
                // $hasMagicAttacks = ($items->canExtendMagic(3) && $items->has('FireRod')) 
                //     || ($items->canExtendMagic(2) && $items->has('FireRod') && $items->has('Bombos'));

                // return ($world->config('itemPlacement') !== 'basic' || $hasMagicAttacks) 
                //     && $items->canMeltThings($world) 
                //     && ($items->has('Hammer') || $hasMagicAttacks);
            case 'Vitreous':
                return ($world->config('itemPlacement') !== 'basic' || $items->canShootArrows($world))
                    && ($items->hasAny(['Hammer', 'Bow'], $world));
                // return ($world->config('itemPlacement') !== 'basic' || $items->canShootArrows($world))
                //     && ($items->has('Hammer') || $items->canShootArrows($world));
            case 'Trinexx':
                return $items->has('FireRod') && $items->has('IceRod') && $items->has('Hammer');
            default:
                return False;
        }
    }
/*
    case 'Armos':
        return $items->hasAny(['Bow', 'Hammer', 'RedBoomerang', 'Boomerang'], $world) ||
            $items->hasRod(4) ||
            $items->hasCane(2);
    case 'Lanmola':
        return $items->hasAny(['Hammer', 'Bow', 'FireRod', 'IceRod', 'CaneOfByrna', 'CaneOfSomaria'], $world);
    case 'Moldorm':
        return $items->has('Hammer');
    case 'Agahnim':
    case 'Agahnim2':
        return $items->hasAny(['Hammer', 'BugCatchingNet']);
    case 'Helmasaur':
        return $items->hasAny(['Hammer', 'Bomb'], $world) && $items->canShootArrows($world);
    case 'Arrghus':
        $canGetArrgi = $items->has('Hookshot');
        $canKillArrgi = $items->has('Hammer') 
            || $items->hasRod(2)
            || ($items->canShootArrows($world) && $items->hasRod());
        return $canGetArrgi && $canKillArrgi;
    case 'Mothula':
        return 
        (
            $world->config('itemPlacement') !== 'basic' || 
            $items->hasEnoughMagic("FireRod", 2)
        ) && 
        (
            $items->has('Hammer') || 
            $items->hasEnoughMagic("FireRod", 2) ||
            $items->hasCane(2) ||
            $items->canGetGoodBee()
        );
    case 'Blind':
        return $items->hasRod() || $items->has('Hammer');
    case 'Kholdstare':
        $hasMagicAttacks = ($items->hasEnoughMagic("FireRod", 3)) 
            || ($items->hasEnoughMagic("FireRod", 2) && $items->hasEnoughMagic("Bombos", 2));

        return ($world->config('itemPlacement') !== 'basic' || $hasMagicAttacks) 
            && $items->canMeltThings($world) 
            && ($items->has('Hammer') || $hasMagicAttacks);
    case 'Vitreous':
        return ($world->config('itemPlacement') !== 'basic' || $items->canShootArrows($world))
            && ($items->hasAny(['Hammer', 'Bow'], $world));
    case 'Trinexx':
        return $items->hasAny(['FireRod', 'IceRod', 'Hammer']);
    default:
        return False;
        */

    abstract public function canPlaceBoss($dungeonName, $bossName);

    abstract public function initWorld(&$config);

    abstract public function prepareWorld($world, &$advancement_items, &$nice_items_swords, &$nice_items);

}