<?php

/*
|--------------------------------------------------------------------------
| Notifynder Configuration
|--------------------------------------------------------------------------
*/

return [

    /*
     * If you have a different user model
     * please specific it here, this option is not
     * considerate if using notifynder as polymorphic
     */
    'model' => 'App\User',

    /*
     * Do you want have notifynder that work polymorphically?
     * just swap the value to true and you will able to use it!
     */
    'polymorphic' => false,

    /*
     * If you need to extend the model class of
     * Notifynder you just need to change this line
     * With the path / NameSpace of your model and extend it
     * with Fenos\Notifynder\Models\Notification
     */
    'notification_model' => \Fenos\Notifynder\Models\Notification::class,

    /*
     * Coordinating a lots notifications that require extra params
     * might cause to forget and not insert the {extra.*} value needed.
     * This flag allow you to cause an exception to be thrown if you miss
     * to store a extra param that the category will need.
     * NOTE: use only in development.
     * WHEN DISABLED: will just remove the {extra.*} markup from the sentence
     */
    'strict_extra' => false,

    /*
     * Enable the laravel included translation. The translations are
     * searched in a `notifynder.php` file in the current language folder.
     * The keys for the translations are the category name.
     */
    'translation'  => [
        'enabled' => false,
        'domain' => 'notifynder',
    ],

    /*
     * If you have added your own fields to the Notification Model
     * you can add them to the arrays below.
     *
     * If you want them to be required by the builder add them to the
     * to the required key - if they are just added you can add them
     * to the fillable key.
     */
    'additional_fields' => [
        'required' => [

        ],
        'fillable' => [

        ],
    ],
];
