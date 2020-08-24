<?php

namespace ALttP;

use ALttP\Support\BossCollection;
use ALttP\Support\ItemCollection;
use ALttP\Support\LocationCollection;

/**
 * Boss Logic for beating each boss
 */
class Boss
{
    /** @var string */
    protected $name;
    /** @var string */
    protected $enemizer_name;
    /** @var callable|null */
    protected $can_beat;
    /** @var array */
    protected static $items;
    /** @var array */
    protected static $worlds = [];

    /**
     * Get the Boss by name
     *
     * @param string $name Name of Boss
     * @param \ALttP\World  $world  World boss belongs to
     *
     * @throws \Exception if the Boss doesn't exist
     *
     * @return \ALttP\Boss
     */
    public static function get(string $name, World $world): Boss
    {
        $items = static::all($world);
        if (isset($items[$name])) {
            return $items[$name];
        }

        throw new \Exception('Unknown Boss: ' . $name);
    }

    /**
     * Clears the internal cache so we don't leak memory in testing.
     *
     * @return void
     */
    public static function clearCache(): void
    {
        static::$items = [];
        static::$worlds = [];
    }

    /**
     * Get the all known Bosses
     *
     * @return \ALttP\Support\BossCollection
     */
    public static function all(World $world): BossCollection
    {
        if (isset(static::$items[$world->id])) {
            return static::$items[$world->id];
        }
        static::$worlds[$world->id] = $world;

        $bossList = [
            "Armos" => "Armos Knights",
            "Lanmola" => "Lanmolas",
            "Moldorm" => "Moldorm",
            "Agahnim" => "Agahnim",
            "Helmasaur" => "Helmasaur King",
            "Arrghus" => "Arrghus",
            "Mothula" => "Mothula",
            "Blind" => "Blind",
            "Kholdstare" => "Kholdstare",
            "Vitreous" => "Vitreous",
            "Trinexx" => "Trinexx",
            "Agahnim2" => "Agahnim2"
        ];

        $bosses = [];

        foreach ($bossList as $bossName => $bossDescription)
        {
            $bosses[] = new static($bossDescription, $bossName, function ($locations, $items) use ($world, $bossName) {
                return $world->checkBossRules($items, $bossName);
            });
        }

        static::$items[$world->id] = new BossCollection($bosses);

        return static::all($world);
    }

    /**
     * Create a new Item.
     *
     * @param string         $name      Unique name of Boss
     * @param callable|null  $can_beat  Rules for beating the Boss
     *
     * @return void
     */
    public function __construct(string $name, string $ename = null, callable $can_beat = null)
    {
        $this->name = $name;
        $this->enemizer_name = $ename ?? $name;
        $this->can_beat = $can_beat;
    }

    /**
     * Get the name of this Boss.
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Get the name of this Boss for Enemizer.
     *
     * @return string
     */
    public function getEName(): string
    {
        return $this->enemizer_name;
    }

    /**
     * Determine if Link can beat this Boss.
     *
     * @param \ALttP\Support\ItemCollection           $items      Items Link can collect
     * @param \ALttP\Support\LocationCollection|null  $locations
     *
     * @return bool
     */
    public function canBeat(ItemCollection $items, ?LocationCollection $locations = null): bool
    {
        if ($this->can_beat === null || call_user_func($this->can_beat, $locations ?? new LocationCollection, $items)) {
            return true;
        }

        return false;
    }
}
