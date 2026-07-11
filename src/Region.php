<?php

declare(strict_types=1);

namespace Freshwork\ChileanBundle;

/**
 * The 16 regions of Chile, backed by their official region number
 * (the same numbering used by INE and government services).
 */
enum Region: int
{
    case Tarapaca = 1;
    case Antofagasta = 2;
    case Atacama = 3;
    case Coquimbo = 4;
    case Valparaiso = 5;
    case OHiggins = 6;
    case Maule = 7;
    case Biobio = 8;
    case Araucania = 9;
    case LosLagos = 10;
    case Aysen = 11;
    case Magallanes = 12;
    case Metropolitana = 13;
    case LosRios = 14;
    case AricaYParinacota = 15;
    case Nuble = 16;

    /**
     * Official name of the region.
     */
    public function officialName(): string
    {
        return match ($this) {
            self::Tarapaca => 'Región de Tarapacá',
            self::Antofagasta => 'Región de Antofagasta',
            self::Atacama => 'Región de Atacama',
            self::Coquimbo => 'Región de Coquimbo',
            self::Valparaiso => 'Región de Valparaíso',
            self::OHiggins => 'Región del Libertador General Bernardo O\'Higgins',
            self::Maule => 'Región del Maule',
            self::Biobio => 'Región del Biobío',
            self::Araucania => 'Región de La Araucanía',
            self::LosLagos => 'Región de Los Lagos',
            self::Aysen => 'Región de Aysén del General Carlos Ibáñez del Campo',
            self::Magallanes => 'Región de Magallanes y de la Antártica Chilena',
            self::Metropolitana => 'Región Metropolitana de Santiago',
            self::LosRios => 'Región de Los Ríos',
            self::AricaYParinacota => 'Región de Arica y Parinacota',
            self::Nuble => 'Región de Ñuble',
        };
    }

    /**
     * Roman numeral of the region ('RM' for the Metropolitan region).
     */
    public function romanNumeral(): string
    {
        return match ($this) {
            self::Tarapaca => 'I',
            self::Antofagasta => 'II',
            self::Atacama => 'III',
            self::Coquimbo => 'IV',
            self::Valparaiso => 'V',
            self::OHiggins => 'VI',
            self::Maule => 'VII',
            self::Biobio => 'VIII',
            self::Araucania => 'IX',
            self::LosLagos => 'X',
            self::Aysen => 'XI',
            self::Magallanes => 'XII',
            self::Metropolitana => 'RM',
            self::LosRios => 'XIV',
            self::AricaYParinacota => 'XV',
            self::Nuble => 'XVI',
        };
    }

    /**
     * Regional capital.
     */
    public function capital(): string
    {
        return match ($this) {
            self::Tarapaca => 'Iquique',
            self::Antofagasta => 'Antofagasta',
            self::Atacama => 'Copiapó',
            self::Coquimbo => 'La Serena',
            self::Valparaiso => 'Valparaíso',
            self::OHiggins => 'Rancagua',
            self::Maule => 'Talca',
            self::Biobio => 'Concepción',
            self::Araucania => 'Temuco',
            self::LosLagos => 'Puerto Montt',
            self::Aysen => 'Coyhaique',
            self::Magallanes => 'Punta Arenas',
            self::Metropolitana => 'Santiago',
            self::LosRios => 'Valdivia',
            self::AricaYParinacota => 'Arica',
            self::Nuble => 'Chillán',
        };
    }

    /**
     * Regions ordered from north to south (geographic order).
     *
     * @return self[]
     */
    public static function northToSouth(): array
    {
        return [
            self::AricaYParinacota,
            self::Tarapaca,
            self::Antofagasta,
            self::Atacama,
            self::Coquimbo,
            self::Valparaiso,
            self::Metropolitana,
            self::OHiggins,
            self::Maule,
            self::Nuble,
            self::Biobio,
            self::Araucania,
            self::LosRios,
            self::LosLagos,
            self::Aysen,
            self::Magallanes,
        ];
    }

    /**
     * All regions as an array suitable for HTML selects: [number => official name].
     *
     * @return array<int, string>
     */
    public static function options(): array
    {
        $options = [];
        foreach (self::northToSouth() as $region) {
            $options[$region->value] = $region->officialName();
        }

        return $options;
    }
}
