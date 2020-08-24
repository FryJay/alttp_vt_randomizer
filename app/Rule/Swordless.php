<?php

namespace ALttP\Rule;

use ALttP\Rule;
use ALttP\Item;

class Swordless extends Rule
{
    /**
     * This Rule changes the game to be swordless.
     */

    public function canBeatBoss($world, $bossName, $items)
    {
        return parent::canBeatBoss($world, $bossName, $items);
    }

    public function canPlaceBoss($dungeonName, $bossName)
    {
        if ($dungeonName == "Ice Palace" && $bossName == "Kholdstare")
        {
            return False;
        }
        return True;
    }

    public function initWorld(&$config)
    {
        $config['region.requireBetterBow'] = true;
        $config['item.overflow.count.Bow'] = 2;
    }

    public function prepareWorld($world, &$advancement_items, &$nice_items_swords, &$nice_items)
    {
        foreach ($nice_items_swords as $unneeded) {
            $nice_items[] = Item::get('TwentyRupees2', $world);
        }
        $world_items = $world->collectItems();
        // check for pregressive bows
        if (!$world_items->merge($advancement_items)->has('ProgressiveBow', 2)) {
            $world_items = $world_items->values();
            if (
                !in_array(Item::get('SilverArrowUpgrade', $world), $world_items)
                && !in_array(Item::get('BowAndSilverArrows', $world), $world_items)
            ) {
                if (array_search(Item::get('SilverArrowUpgrade', $world), $nice_items) === false && $world->config('difficulty') !== 'custom') {
                    $advancement_items[] = Item::get('SilverArrowUpgrade', $world);
                }
            }
        }
    }
}