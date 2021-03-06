<?php
/**
 * Copyright (C) MIKO LLC - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * Written by Nikolay Beketov, 5 2018
 *
 */

namespace Models;

use Phalcon\Mvc\Model\Relation;
use Phalcon\Mvc\Model\ResultsetInterface;

class NetworkFilters extends ModelsBase
{
    /**
     * @Primary
     * @Identity
     * @Column(type="integer", nullable=false)
     */
    public $id;

    /**
     * @Column(type="string", nullable=true)
     */
    public $permit;

    /**
     * @Column(type="string", nullable=true)
     */
    public $deny;

    /**
     * @Column(type="integer", nullable=true)
     */
    public $newer_block_ip;

    /**
     * @Column(type="integer", nullable=true)
     */
    public $local_network;

    /**
     * @Column(type="string", nullable=true)
     */
    public $description;

    public function getSource(): string
    {
        return 'm_NetworkFilters';
    }

    public function initialize(): void
    {
        parent::initialize();
        $this->hasMany(
            'id',
            'Models\Sip',
            'networkfilterid',
            [
                'alias'      => 'Sip',
                'foreignKey' => [
                    'allowNulls' => true,
                    'action'     => Relation::NO_ACTION,
                ],
            ]
        );
        $this->hasMany(
            'id',
            'Models\FirewallRules',
            'networkfilterid',
            [
                'alias'      => 'FirewallRules',
                'foreignKey' => [
                    'allowNulls' => true,
                    'action'     => Relation::ACTION_CASCADE,
                ],
            ]
        );
        $this->hasMany(
            'id',
            'Models\AsteriskManagerUsers',
            'networkfilterid',
            [
                'alias'      => 'AsteriskManagerUsers',
                'foreignKey' => [
                    'allowNulls' => true,
                    'action'     => Relation::NO_ACTION,
                ],
            ]
        );
    }

    /**
     * Вернуть список подсетей с разрешенным типом трафика
     *
     * @param array $arrTrafficCategory
     *
     * @return ResultsetInterface
     */
    public static function getAllowedFiltersForType($arrTrafficCategory): ResultsetInterface
    {
        $parameters = [
            'conditions' => 'FirewallRules.category in ({arrkeys:array}) and FirewallRules.action="allow"',
            'bind'       => [
                'arrkeys' => $arrTrafficCategory,
            ],
            'joins'      => [
                'FirewallRules' => [
                    0 => '\Models\FirewallRules',
                    1 => 'FirewallRules.networkfilterid=\Models\NetworkFilters.id',
                    2 => 'FirewallRules',
                    3 => 'INNER',
                ],
            ],
        ];

        return NetworkFilters::find($parameters);
    }

}

