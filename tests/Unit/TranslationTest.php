<?php

namespace Pine\Translatable\Tests\Unit;

use Pine\Translatable\Translation;
use Pine\Translatable\Tests\TestCase;
use Pine\Translatable\Tests\Translatable;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TranslationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_translation_belongs_to_a_translatable_model()
    {
        $translatable = factory(Translatable::class)->create();

        $translation = $translatable->translations()->save(factory(Translation::class)->make(['language' => 'hu']));

        $this->assertEquals($translatable->id, $translation->translatable->id);
    }
}
