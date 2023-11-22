<?php

namespace TomatoPHP\TomatoEcommerce\Sections;

use TomatoPHP\TomatoCms\Facades\TomatoCMS;
use TomatoPHP\TomatoCms\Services\Contracts\Section;
use TomatoPHP\TomatoForms\Facades\TomatoForms;
use TomatoPHP\TomatoForms\Services\Contracts\Form;
use TomatoPHP\TomatoForms\Services\Contracts\FormInput;

class TomatoHeroSection
{
    public static function build(): void
    {
        TomatoForms::register((new self())->form());
        TomatoCMS::registerSection((new self())->section());
    }

    public function __construct()
    {
        TomatoForms::register($this->form());
        TomatoCMS::registerSection($this->section());
    }

    public function form(): Form
    {
        return Form::make()
            ->title(__('Hero'))
            ->name(__('Hero Section Form'))
            ->key('tomato_hero')
            ->inputs([
                FormInput::make()
                    ->name('title_ar')
                    ->type('text')
                    ->toArray(),
                FormInput::make()
                    ->name('title_en')
                    ->type('text')
                    ->toArray(),
                FormInput::make()
                    ->name('description_ar')
                    ->type('textarea')
                    ->toArray(),
                FormInput::make()
                    ->name('description_en')
                    ->type('textarea')
                    ->toArray(),
                FormInput::make()
                    ->name('button_ar')
                    ->type('text')
                    ->toArray(),
                FormInput::make()
                    ->name('button_en')
                    ->type('text')
                    ->toArray(),
                FormInput::make()
                    ->name('url')
                    ->type('text')
                    ->toArray()
            ]);
    }

    public function section(): Section
    {
        return Section::make()
            ->lock(true)
            ->key('tomato_hero')
            ->icon('bx bx-circle')
            ->form('tomato_hero')
            ->view('tomato-ecommerce::sections.home.hero')
            ->type('section');
    }
}
