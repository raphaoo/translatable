# Translatable

Simple Eloquent model translations.

## Getting Started

You can install the package with composer, running the ``composer require thepinecode/translatable`` command.

If you have any question how the package works, we suggest to read this post:
[Simple Eloquent Model Translations](https://pineco.de/simple-eloquent-model-translations/).

> The package supports Laravel 5.5 or higher!

#### Disable the autodiscovery for the package

In some cases you may disable autodiscovery for this package.
You can add the provider class to the ``dont-discover`` array to disable it.

Then you need to register it manually again.
You can do that in ``config/app.php`` file.
Add the ``Pine\Translatable\TranslatableServiceProvider::class`` to the providers array.

## The Translation Mechanism

The translation mechanism is very simple. The original content (in the default language)
should be stored in your translatable model. The contents in any other language should be stored
in the translations model.

The following points introduces the workflow that you can apply to retrieve the translations you need.

### The Translatable Trait

The key of making models translatable is to add the ``Translatable`` trait to them.
By adding the trait, the package initializes a polimorphic relationship between the translatable model
and the translation model automatically.

```php
use Pine\Translatable\Translatable;

class Post extends Model
{
    use Translatable;
}
```

You can retrieve all the translations of a model by using the ``translations``property. It returns a collection
of the translations. You can handle them as any other Eloquent collection.

```php
// Returns the collection of translations
$post->translations;
```

Also, if you want to get a translation of a given language, you can use the ``translate()`` method on the model.
If you omit the langauge, the method will use the current app language to get the translation.
It returns the translation paired the given language or returns ``null`` if there is no translation.

```php
// Returns the hungarian translation model instance if present
$post->translate('hu');
```

If you need only the translation paired with the current application language, you can use the ``translation`` property.
Since, it uses the ``translate()``method, if there is no translation for the current language, it returns ``null``.

```php
App::setLocale('hu');

// Returns the hungarian translation if present
$post->translation;
```

> If you want to append the translation property to the array / JSON representation of the model,
> don't forget to add it to the ``$appends`` array.

### The Translations Migration

The includes the migration for the translations. The translation content is in JSON data type, what makes possible
to use special MySql JSON syntax on the content column.

```php
$post->translation->update(['content->title' => 'New Title']);
```

> You need MySql 5.7+ to use the JSON  feature.

If your database engine does not support JSON, it will be stored as a text format and we cast it as an array
on the Laravel's end.

Why JSON? With JSON we can represent the translatable model's structure without any restrictions.
Flexible, yet simple solution.

### The Translation Model

The models full namespace is ``Pine\Translatable\Translation``.
You can use it as any other model, no suprises here.

## The @translate Blade Directive

The ``@translate``directive provides a clean alternative for the following code:

```
// Instead of this
{{ $post->translate($lang)->content['title'] ?? $post->title }}

// You can do this
@translate('title', $post, $lang)
```

The first parameter is the property of the model what you want to transalte.

> The second parameter always should be a translatable Elqouent model!

You can omit the 3rd parameter. If you don't specify a language the current application language
will take place.

## Creating Translations

There is no fixed way to create translations. You can do it in several ways, it's totally up to you.

We show a very basic example to point the structure you need to follow when creating a new translation.
Let's say we have nested controllers with the following route structure:

```php
# Posts
Route::resource('posts', 'PostsController');

# Translations
Route::resource('posts.translations', 'TranslationsController');
```

The store method at the TranslationsController should look like the following:

```php
// app/Http/Controllers/TranslationsController

public function store(Request $request, Post $post)
{
    $post->translations()->create([
        'language' => 'hu',
        'content' => [
            'title' => $request->translation_title,
            'body' => $request->translation_body,
        ],
    ]);
}
```

> Note, we are using route-model bindig for the post model.

The language attribute is required and every language can be stored once for every post.
Since, we automatically cast the content as an array, we have to provide an array when creating a model,
and the rest will be done by Laravel.

Here you need to pay attention, you need to "recreate" the structure of the model what is being translated.
