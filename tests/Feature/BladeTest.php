<?php

namespace Pine\Translatable\Tests\Feature;

use Pine\Translatable\Translation;
use Illuminate\Support\Facades\App;
use Pine\Translatable\Tests\TestCase;
use Pine\Translatable\Tests\Translatable;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TranslatableTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function views_can_use_the_blade_directive()
    {
        $translatable = factory(Translatable::class)->create();

        $translatable->translations()->saveMany([
            factory(Translation::class)->make(['language' => 'hu']),
            factory(Translation::class)->make(['language' => 'fr']),
            factory(Translation::class)->make(['language' => 'de']),
            factory(Translation::class)->make(['language' => 'ro']),
        ]);

        $this->get('/translatable')
            ->assertSee($translatable->title);

        App::setLocale('hu');
        $this->get('/translatable')
            ->assertSee($translatable->translate('hu')->content['title']);

        App::setLocale('fr');
        $this->get('/translatable')
            ->assertSee($translatable->translate('fr')->content['title']);

        App::setLocale('de');
        $this->get('/translatable')
            ->assertSee($translatable->translate('de')->content['title']);

        App::setLocale('ro');
        $this->get('/translatable')
            ->assertSee($translatable->translate('ro')->content['title']);
    }
}
