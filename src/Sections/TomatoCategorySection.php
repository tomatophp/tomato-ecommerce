<?php

namespace TomatoPHP\TomatoEcommerce\Sections;

use TomatoPHP\TomatoCms\Facades\TomatoCMS;
use TomatoPHP\TomatoCms\Services\Contracts\Section;
use TomatoPHP\TomatoForms\Facades\TomatoForms;
use TomatoPHP\TomatoForms\Services\Contracts\Form;
use TomatoPHP\TomatoForms\Services\Contracts\FormInput;

class TomatoCategorySection
{
    public static function build(): void
    {
        TomatoForms::register((new self())->form());
        TomatoCMS::registerSection((new self())->section());
    }

    public function form(): Form
    {
        return Form::make()
            ->title(__('Tomato Category'))
            ->name(__('Tomato Category Section Form'))
            ->key('tomato_category')
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
                    ->type('text')
                    ->toArray(),
                FormInput::make()
                    ->name('description_en')
                    ->type('text')
                    ->toArray(),
                FormInput::make()
                    ->name('categories')
                    ->type('select')
                    ->is_from_table(true)
                    ->option_label('name.'.app()->getLocale())
                    ->option_value('id')
                    ->table_name('/admin/categories/api?for=product-categories')
                    ->is_multi(true)
                    ->toArray(),
            ]);
    }

    public function section(): Section
    {
        return Section::make()
            ->lock(true)
            ->key('tomato_category')
            ->icon('bx bx-circle')
            ->form('tomato_category')
            ->view('tomato-ecommerce::sections.home.category')
            ->type('section');
    }
}
