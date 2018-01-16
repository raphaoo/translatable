<?php

namespace Pine\Translatable;

use Illuminate\Support\Facades\App;

trait Translatable
{
    /**
     * Get all of the models's translations.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function translations()
    {
        return $this->morphMany(Translation::class, 'translatable');
    }

    /**
     * Translate the model to the given or the current language.
     *
     * @param  string|null  $lang
     * @return \Pine\Translatable\Translation|null
     */
    public function translate($lang = null)
    {
        return $this->translations->firstWhere(
            'language', $lang ?? App::getLocale()
        );
    }

    /**
     * Get the default translation.
     *
     * @return \Pine\Translatable\Translation|null
     */
    public function getTranslationAttribute()
    {
        return $this->translate();
    }
}
