# Configuration

> We are working to make the Help Desk application configurable as much as possible.

You can check the below section to see what you can configure easily by using the file `config/system.php`.

## Locales

For now the Help Desk comes with two languages **English** and **French**, so if you are planing to add more languages to the application by adding `lang/**` files, you need to update the `config('system.locales')` configuration.

Below is the default configuration:

```php
'locales' => [
    'en' => 'English',
    'fr' => 'Français'
],
```

### Example

If you want to add the **Arabic** language, you need to translate the `lang/fr.json` file into a new file name `lang/ar.json`, the update the configuration like the following:

```php
'locales' => [
    'en' => 'English',
    'fr' => 'Français',
    'ar' => 'العربية'
],
```

## Main menu

The application main menu is configurable as well in the `config('system.main_menu')` configuration parameter.

You can check the configuration file `config/system.php`, there is the comment below that explains all the parameters you can use to configure your main menu:

```php
/*
|--------------------------------------------------------------------------
| Main menu configuration
|--------------------------------------------------------------------------
|
| This value is the definition of the application main menu
| Used in the 'App\View\Components\MainMenu' blade component
|
| Parameters:
| -----------
|   - 'title' The translatable title of the menu
|
|   - 'route' The menu route name
|
|   - 'icon' The Fontawesome icon class
|           (icons list: http://fontawesome.io/icons/)
|
|   - 'always_shown' If equals to "true" the menu is always shown without
|           checking permissions, if "false" the 'permissions' parameter
|           is used to show or not the menu item
|
|   - 'show_notification_indicator' If equals to "true" the menu item will
|           show an indicator if there is notifications not read
|
|   - 'permissions' The permissions used to show or not the menu item
|
|   - (Optional) 'children' The sub menu items
|       - 'children.title' The translatable title of the sub menu
|
|       - 'children.route' The sub menu route name
|
|       - 'children.icon' The Fontawesome icon class
|           (icons list: http://fontawesome.io/icons/)
|
|       - 'children.always_shown' If equals to "true" the menu is always
|           shown without checking permissions, if "false"
|           the 'permissions' parameter is used to show or not
|           the menu item
|
|       - 'children.permissions' The permissions used to show or not
|           the menu item
|
*/
```
