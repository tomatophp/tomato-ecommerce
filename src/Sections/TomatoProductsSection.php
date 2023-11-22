<?php

namespace TomatoPHP\TomatoEcommerce\Sections;

use TomatoPHP\TomatoCms\Facades\TomatoCMS;
use TomatoPHP\TomatoCms\Services\Contracts\Section;
use TomatoPHP\TomatoForms\Facades\TomatoForms;
use TomatoPHP\TomatoForms\Services\Contracts\Form;
use TomatoPHP\TomatoForms\Services\Contracts\FormInput;

class TomatoProductsSection
{
    public static function build(): void
    {
        TomatoForms::register((new self())->form());
        TomatoCMS::registerSection((new self())->section());
    }

    public function form(): Form
    {
        return Form::make()
            ->title(__('Tomato Products'))
            ->name(__('Tomato Products Section Form'))
            ->key('tomato_products')
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
                    ->name('products')
                    ->type('select')
                    ->is_from_table(true)
                    ->option_label('name.'.app()->getLocale())
                    ->option_value('id')
                    ->table_name('/admin/products/api')
                    ->is_multi(true)
                    ->toArray(),
            ]);
    }

    public function section(): Section
    {
        return Section::make()
            ->lock(true)
            ->key('tomato_products')
            ->icon('bx bx-circle')
            ->form('tomato_products')
            ->view('tomato-ecommerce::sections.products.products-section')
            ->type('section');
    }
}
