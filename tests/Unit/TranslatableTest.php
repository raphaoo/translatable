<?php

namespace Pine\Translatable\Tests\Unit;

use Pine\Translatable\Translation;
use Illuminate\Support\Facades\App;
use Pine\Translatable\Tests\TestCase;
use Pine\Translatable\Tests\Translatable;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TranslatableTest extends TestCase
{
    use RefreshDatabase;

    protected $translatable, $translation;

    public function setUp()
    {
        parent::setUp();

        $this->translatable = factory(Translatable::class)->create();

        $this->translation = $this->translatable->translations()->save(factory(Translation::class)->make(['language' => 'hu']));
    }

    /** @test */
    public function a_translatable_model_has_translations()
    {
        $this->assertTrue($this->translatable->translations->pluck('id')->contains($this->translation->id));
    }

    /** @test */
    public function a_translatable_model_has_a_translation_based_on_the_current_language()
    {
        $this->assertNull($this->translatable->translation);

        App::setLocale('hu');

        $this->assertEquals($this->translatable->translation->id, $this->translation->id);
    }
}
