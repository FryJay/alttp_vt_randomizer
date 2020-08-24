<?php

namespace ALttP\Rule;

use ALttP\Rule\Swordless;

class Sworded extends Swordless
{
    /**
     * This Rule changes the game to allow swords.
     */

    public function canBeatBoss($world, $bossName, $items)
    {
        $swordlessResult = parent::canBeatBoss($world, $bossName, $items);
        $swordedResult = False;
        
        switch ($bossName)
        {
            case 'Armos':
            case 'Lanmola':
            case 'Moldorm':
            case 'Agahnim':
            case 'Agahnim2':
                $swordedResult = $items->hasSword();
                break;
            case 'Helmasaur':
                $swordedResult = $items->hasAny(['Bomb', 'Hammer'])
                    && ($items->hasSword(2) || $world->config('itemPlacement') !== 'basic');
                // $swordedResult = ($items->canBombThings() || $items->has('Hammer'))
                //     && ($items->hasSword(2) || $world->config('itemPlacement') !== 'basic');
                break;
            case 'Arrghus':
                $canGetArrgi = $items->has('Hookshot');
                $canKillArrgi = 
                (
                    $world->config('itemPlacement') !== 'basic' || 
                    $items->hasSword(2)
                ) && 
                (
                    $items->hasAny(['Hammer', 'Sword']) ||
                    (
                        (
                            $items->canExtendMagic(2) || 
                            $items->canShootArrows($world)
                        ) && 
                        $items->hasRod()
                    )
                );

                $swordedResult = $canGetArrgi && $canKillArrgi;
                break;
                // $canGetArrgi = $items->has('Hookshot');
                // $canKillArrgi = 
                // (
                //     $world->config('itemPlacement') !== 'basic' || 
                //     $items->hasSword(2)
                // ) && 
                // (
                //     $items->hasAny(['Hammer', 'Sword']) ||
                //     // $items->has('Hammer') || 
                //     // $items->hasSword() || 
                //     (
                //         (
                //             $items->canExtendMagic(2) || 
                //             $items->canShootArrows($world)
                //         ) &&
                //         (
                //             $items->has('FireRod') || 
                //             $items->has('IceRod')
                //         )
                //     )
                // );

                // $swordedResult = $canGetArrgi && $canKillArrgi;
                // break;
            case 'Mothula':
                $swordedResult = 
                (
                    $world->config('itemPlacement') !== 'basic' || 
                    $items->hasSword(2) || 
                    $items->hasEnoughMagic('FireRod', 2)
                ) && 
                (
                    $items->hasAny(["Sword", "Hammer", "CaneOfByrna", "CaneOfSomaria"]) ||
                    $items->hasEnoughMagic('FireRod', 2) || 
                    $items->canGetGoodBee()
                );
                break;
                // $swordedResult = ($world->config('itemPlacement') !== 'basic' || $items->hasSword(2) || ($items->canExtendMagic(2) && $items->has('FireRod')))
                //     && ($items->hasSword() || $items->has('Hammer')
                //         || ($items->canExtendMagic(2) && ($items->has('FireRod') || $items->has('CaneOfSomaria')
                //             || $items->has('CaneOfByrna')))
                //         || $items->canGetGoodBee());
                // break;
            case 'Blind':
                $swordedResult = 
                (
                    $world->config('itemPlacement') !== 'basic' || 
                    (
                        $items->hasSword() && 
                        $items->hasAny(['Cape', 'CaneOfByrna'])
                    )
                ) && 
                $items->hasAny(['Sword', 'Hammer', 'CaneOfByrna', 'CaneOfSomaria']);
                break;
            case 'Kholdstare':
                $swordedResult = 
                (
                    $world->config('itemPlacement') !== 'basic' || 
                    $items->hasSword(2) || 
                    $items->hasEnoughMagic('FireRod', 3) ||
                    (
                        $items->hasAny(['Sword', 'Bombos']) &&
                        $items->hasEnoughMagic('FireRod', 2)
                    )
                ) && 
                $items->canMeltThings($world) && 
                (
                    $items->hasAny(['Sword', 'Hammer']) ||
                    $items->hasEnoughMagic('FireRod', 3)
                );
                break;
            case 'Vitreous':
                $swordedResult = ($world->config('itemPlacement') !== 'basic' || $items->hasSword(2) || $items->canShootArrows($world))
                    && ($items->has('Hammer') || $items->hasSword() || $items->canShootArrows($world));
                break;
            case 'Trinexx':
                $swordedResult = $items->has('FireRod') && $items->has('IceRod')
                        && ($world->config('itemPlacement') !== 'basic' || $items->hasSword(3) || ($items->canExtendMagic(2) && $items->hasSword(2)))
                        && ($items->hasSword(3) || $items->has('Hammer')
                            || ($items->canExtendMagic(2) && $items->hasSword(2))
                            || ($items->canExtendMagic(4) && $items->hasSword()));
                break;
            default:
                break;
        }

        return $swordlessResult || $swordedResult;
    }
/*
        switch ($bossName)
        {
            case 'Armos':
            case 'Lanmola':
            case 'Moldorm':
            case 'Agahnim':
            case 'Agahnim2':
                $swordedResult = $items->hasSword();
                break;
            case 'Helmasaur':
                $swordedResult = $items->hasAny(['Bomb', 'Hammer'])
                    && ($items->hasSword(2) || $world->config('itemPlacement') !== 'basic');
                break;
            case 'Arrghus':
                $canGetArrgi = $items->has('Hookshot');
                $canKillArrgi = 
                (
                    $world->config('itemPlacement') !== 'basic' || 
                    $items->hasSword(2)
                ) && 
                (
                    $items->hasAny(['Hammer', 'Sword']) ||
                    (
                        (
                            $items->canExtendMagic(2) || 
                            $items->canShootArrows($world)
                        ) && 
                        $items->hasRod()
                    )
                );

                $swordedResult = $canGetArrgi && $canKillArrgi;
                break;
            case 'Mothula':
                $swordedResult = 
                (
                    $world->config('itemPlacement') !== 'basic' || 
                    $items->hasSword(2) || 
                    $items->hasEnoughMagic('FireRod', 2)
                ) && 
                (
                    $items->hasAny(["Sword", "Hammer", "CaneOfByrna", "CaneOfSomaria"]) ||
                    $items->hasEnoughMagic('FireRod', 2) || 
                    $items->canGetGoodBee()
                );
                break;
            case 'Blind':
                $swordedResult = 
                (
                    $world->config('itemPlacement') !== 'basic' || 
                    (
                        $items->hasSword() && 
                        $items->hasAny(['Cape', 'CaneOfByrna'])
                    )
                ) && 
                $items->hasAny(['Sword', 'Hammer', 'CaneOfByrna', 'CaneOfSomaria']);
                break;
            case 'Kholdstare':
                $swordedResult = ($world->config('itemPlacement') !== 'basic' || $items->hasSword(2) || ($items->canExtendMagic(3) && $items->has('FireRod'))
                        || ($items->has('Bombos') && ($items->hasSword()) && $items->canExtendMagic(2) && $items->has('FireRod')))
                        && $items->canMeltThings($world) && ($items->has('Hammer') || $items->hasSword()
                            || ($items->canExtendMagic(3) && $items->has('FireRod')));
                break;
            case 'Vitreous':
                $swordedResult = ($world->config('itemPlacement') !== 'basic' || $items->hasSword(2) || $items->canShootArrows($world))
                    && ($items->has('Hammer') || $items->hasSword() || $items->canShootArrows($world));
                break;
            case 'Trinexx':
                $swordedResult = $items->has('FireRod') && $items->has('IceRod')
                        && ($world->config('itemPlacement') !== 'basic' || $items->hasSword(3) || ($items->canExtendMagic(2) && $items->hasSword(2)))
                        && ($items->hasSword(3) || $items->has('Hammer')
                            || ($items->canExtendMagic(2) && $items->hasSword(2))
                            || ($items->canExtendMagic(4) && $items->hasSword()));
                break;
            default:
                break;
        }

        return $swordlessResult || $swordedResult;
    }
*/

    public function canPlaceBoss($dungeonName, $bossName)
    {
        return parent::canPlaceBoss($dungeonName, $bossName);
    }

    public function initWorld(&$config)
    {
        parent::initWorld($config);
    }

    public function prepareWorld($world, &$advancement_items, &$nice_items_swords, &$nice_items)
    {
        parent::prepareWorld($world, $advancement_items, $nice_items_swords, $nice_items);
    }
}