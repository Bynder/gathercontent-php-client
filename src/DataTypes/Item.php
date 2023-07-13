<?php

namespace GatherContent\DataTypes;

class Item extends Base
{
    /**
     * @var int
     */
    public $projectId = 0;

    /**
     * @var string
     */
    public $folderUuid = '';

    /**
     * @var int
     */
    public $templateId = 0;

    /**
     * @var string
     */
    public $structureUuid = '';

    /**
     * @var \GatherContent\DataTypes\Structure
     */
    public $structure = null;

    /**
     * @var string
     */
    public $position = '';

    /**
     * @var string
     */
    public $name = '';

    /**
     * @var null|int
     */
    public $archivedBy = null;

    /**
     * @var string
     */
    public $archivedAt = '';

    /**
     * @var string
     */
    public $createdAt = '';

    /**
     * @var string
     */
    public $updatedAt = '';

    /**
     * @var string
     */
    public $nextDueAt = '';

    /**
     * @var string
     */
    public $completedAt = '';

    /**
     * @var \GatherContent\DataTypes\ElementBase[]
     */
    public $content = [];

    /**
     * @var null|int
     */
    public $statusId = null;

    /**
     * @var array
     */
    public $assignedUserIds = [];

    /**
     * @var null|int
     */
    public $assigneeCount = null;

    /**
     * @var null|int
     */
    public $approvalCount = null;

    /**
     * @var array
     */
    public $assets = [];

    protected function initPropertyMapping()
    {
        parent::initPropertyMapping();
        $this->propertyMapping = array_replace(
            $this->propertyMapping,
            [
                'project_id' => 'projectId',
                'folder_uuid' => 'folderUuid',
                'template_id' => 'templateId',
                'structure' => [
                    'type' => 'subConfig',
                    'class' => Structure::class,
                ],
                'structure_uuid' => 'structureUuid',
                'position' => 'position',
                'name' => 'name',
                'archived_by' => 'archivedBy',
                'archived_at' => 'archivedAt',
                'created_at' => 'createdAt',
                'updated_at' => 'updatedAt',
                'next_due_at' => 'nextDueAt',
                'completed_at' => 'completedAt',
                'status_id' => 'statusId',
                'assigned_user_ids' => 'assignedUserIds',
                'assignee_count' => 'assigneeCount',
                'approval_count' => 'approvalCount',
                'content' => [
                    'type' => 'closure',
                    'closure' => function (array $data) {
                        $elements = [];
                        foreach ($data as $key => $elementData) {
                            if (!is_array($elementData)) {
                                $elements[$key] = new ElementSimpleText(['value' => $elementData]);
                                continue;
                            }

                            $elements[$key] = $this->getSubElements($elementData);
                        }

                        return $elements;
                    },
                ],
                'assets' => 'assets',
            ]
        );

        return $this;
    }

    /**
     * Return sub element type.
     *
     * @param  array  $elementData
     * @return array|ElementBase[]
     */
    protected function getSubElements(array $elementData)
    {
        $elements = [];

        foreach ($elementData as $key => $element) {
            if (empty($element)) {
                continue;
            }
            $class = null;
            if (isset($element['id']) && isset($element['label'])) {
                $class = ElementSimpleChoice::class;
            } elseif (isset($element['file_id'])) {
                $class = ElementSimpleFile::class;
            } elseif (!is_array($element)) {
                $class = ElementSimpleText::class;
                $element = ['value' => $element];
            } elseif (is_array($element)) {
                // This is an asset element that allows several files,
                // or a mutlichoice element.
                $elements[$key] = $this->getSubElements($element);
                continue;
            }
            /** @var \GatherContent\DataTypes\ElementBase[] $elements */
            if ($class) {
                $elements[$key] = new $class($element);
            }
        }

        return $elements;
    }
}
