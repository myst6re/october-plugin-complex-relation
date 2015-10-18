<?php namespace Myst6re\Relation\Widgets;

use Backend\FormWidgets\Relation;
use Illuminate\Database\Eloquent\Relations\Relation as RelationBase;

class ComplexRelation extends Relation
{

    /**
     * @var array Form field configuration
     */
    public $form;

    /**
     * @var array If these fields are empty, the association is not created
     */
    public $required_fields;

    protected $defaultAlias = 'complex_relation';

    /**
     * @var array Collection of form widgets.
     */
    protected $formWidgets = [];

    public function widgetDetails()
    {
        return [
            'name'        => 'myst6re.relation::lang.widgets.complex_relation.name',
            'description' => 'myst6re.relation::lang.widgets.complex_relation.description'
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function init()
    {
        parent::init();

        $this->fillFromConfig([
            'form',
            'required_fields',
        ]);
    }

    /**
     * {@inheritDoc}
     */
    public function prepareVars()
    {
        $this->vars['field'] = $field = $this->makeRenderFormField();
        $this->vars['formWidgets'] = $this->makeRenderFormWidgets($field);
    }

    /**
     * Makes the form object used for rendering a simple field type
     */
    protected function makeRenderFormWidgets($field)
    {
        $formWidgets = [];

        list($model, $attribute) = $this->resolveModelAttribute($this->valueFrom);
        $relationObject = $model->{$attribute};

        foreach ($field->options as $id => $option) {
            $associatedModel = $relationObject->find($id);

            if ($associatedModel && $associatedModel->pivot) {
                $data = $associatedModel->pivot->getAttributes();
            } else {
                $data = [];
            }

            $config = $this->makeConfig($this->form);
            $config->model = $model;
            $config->data = $data;
            $config->alias = $this->alias . 'Form'.$id;
            $config->arrayName = $this->formField->getName() . '[' . $id . ']';

            $widget = $this->makeWidget('Backend\Widgets\Form', $config);
            $widget->bindToController();

            $formWidgets[$id] = $widget;
        }

        return $this->formWidgets = $formWidgets;
    }

    /**
     * {@inheritDoc}
     */
    public function getSaveValue($value)
    {
        $value = parent::getSaveValue($value);
        if ($value === null) {
            return null;
        }

        if (is_array($value)) {
            foreach ($value as $key => $pivots) {
                foreach ($pivots as $pivot_key => $pivot_value) {
                    if (!$pivot_value && in_array($pivot_key, $this->required_fields)) {
                        unset($value[$key]);
                        break;
                    }
                }
            }
        }

        return $value;
    }
}
