<?php

namespace GatherContent\DataTypes;

class Group extends Base
{
    public static $type2Class = [
        'text' => ElementText::class,
        'attachment' => Element::class,
        'guidelines' => ElementGuideline::class,
        'choice_checkbox' => ElementCheckbox::class,
        'choice_radio' => ElementRadio::class,
        'component' => ElementComponent::class,
    ];

    /**
     * @var string
     */
    public $name = '';

    /**
     * @var \GatherContent\DataTypes\Element[]
     */
    public $fields = [];

    /**
     * {@inheritdoc}
     */
    protected $unusedProperties = ['id'];

    protected function initPropertyMapping()
    {
        parent::initPropertyMapping();
        $this->propertyMapping = array_replace(
            $this->propertyMapping,
            [
                'uuid' => 'id',
                'name' => 'name',
                'fields' => [
                    'type' => 'closure',
                    'closure' => function (array $data) {
                        $elements = [];
                        foreach ($data as $elementData) {
                            $class = static::$type2Class[$elementData['field_type']];
                            /** @var \GatherContent\DataTypes\Base $element */
                            $element = new $class($elementData);
                            $elements[$element->id] = $element;
                        }

                        return $elements;
                    },
                ],
            ]
        );

        return $this;
    }

  public function jsonSerialize() {
    $json = parent::jsonSerialize();

    // To send a structure to the API, fields must be an array, not keyed
    // by the UUID.
    $json['fields'] = array_values($json['fields']);

    return $json;
  }

}
