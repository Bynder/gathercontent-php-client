<?php

namespace GatherContent\Tests\Unit\DataTypes;

use GatherContent\DataTypes\ElementSimpleChoice;

/**
 * @group GatherContentClient
 */
class ElementSimpleChoiceTest extends BaseTest
{
    /**
     * {@inheritdoc}
     */
    protected $className = ElementSimpleChoice::class;

    /**
     * {@inheritdoc}
     */
    public function casesConstructor()
    {
        $cases = parent::casesConstructor();
        $cases['basic'][0] = [
            'label' => 'test label',
        ];
        $cases['basic'][1] = [
            'label' => 'test label',
        ];

        return $cases;
    }
}
