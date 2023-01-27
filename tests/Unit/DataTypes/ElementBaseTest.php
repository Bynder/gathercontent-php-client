<?php

namespace GatherContent\Tests\Unit\DataTypes;

use GatherContent\DataTypes\ElementBase;

/**
 * @group GatherContentClient
 */
class ElementBaseTest extends BaseTest
{
    /**
     * {@inheritdoc}
     */
    protected $className = ElementBase::class;

    public function testGetSetValue()
    {
        /** @var \GatherContent\DataTypes\ElementBase $element */
        $element = new $this->className([]);

        static::assertEquals('', $element->getValue());

        $element->setValue('a');
        static::assertEquals('', $element->getValue());
    }
}
