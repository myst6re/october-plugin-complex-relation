<?php namespace Myst6re\Relation;

/**
 * The plugin.php file (called the plugin initialization script) defines the plugin information class.
 */

use System\Classes\PluginBase;

class Plugin extends PluginBase
{

    public function pluginDetails()
    {
        return [
            'name'        => 'myst6re.relation::lang.plugin.name',
            'description' => 'myst6re.relation::lang.plugin.description',
            'author'      => 'myst6re',
            // 'icon'        => 'icon-gamepad'
        ];
    }

    public function registerFormWidgets()
    {
        return [
            '\Myst6re\Relation\Widgets\ComplexRelation' => [
                'label' => 'myst6re.relation::lang.widgets.complex_relation.name',
                'code'  => 'complex_relation'
            ]
        ];
    }
}
