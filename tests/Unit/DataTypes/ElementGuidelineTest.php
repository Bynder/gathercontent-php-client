<?php

namespace GatherContent\Tests\Unit\DataTypes;

use GatherContent\DataTypes\ElementGuideline;

/**
 * @group GatherContentClient
 */
class ElementGuidelineTest extends BaseTest
{
    /**
     * {@inheritdoc}
     */
    protected $className = ElementGuideline::class;

    /**
     * {@inheritdoc}
     */
    public function casesConstructor()
    {
        $cases = parent::casesConstructor();
        $cases['basic'][0] = [
            'id' => 'uuid-123',
            'type' => 'guidelines',
            'label' => 'label string',
            'instructions' => 'instruction string',
            'metaData' => [],
        ];
        $cases['basic'][1] = [
            'uuid' => 'uuid-123',
            'field_type' => 'guidelines',
            'label' => 'label string',
            'instructions' => 'instruction string',
            'metaData' => [],
        ];

        return $cases;
    }
}
