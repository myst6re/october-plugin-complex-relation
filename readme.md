# Complex relation widget Plugin

This plugin creates a widget to edit many-to-many relations with pivot data.

## Configuring model

You model must have a many-to-many relationship with pivot data.

## Configuring widget

The name of the widget is "complex_relation".

Options :

 * nameFrom : the column name to use in the relation used for displaying the name. Default: name.
 * descriptionFrom : the column name to use in the relation used for displaying a description (optional). Default: description.
 * emptyOption : text to display when there is no available selections.
 * required_fields : list of required fields, used to create or not the relation if the specified fields are filled.
 * form : a reference to form field definition file, see [backend form fields](http://octobercms.com/docs/backend/forms#form-fields). Inline fields can also be used.

## Limitations

You must have at least one required field to create the relation. (An alternative will be use checkbox to select associations to use, be it is not implemented yet).

Doesn't work with file uploads, because you need to create the pivot model before the model is created.
