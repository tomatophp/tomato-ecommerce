<?php

namespace TomatoPHP\TomatoEcommerce\Sections;

use TomatoPHP\TomatoCms\Facades\TomatoCMS;
use TomatoPHP\TomatoCms\Services\Contracts\Section;
use TomatoPHP\TomatoForms\Facades\TomatoForms;
use TomatoPHP\TomatoForms\Services\Contracts\Form;
use TomatoPHP\TomatoForms\Services\Contracts\FormInput;

class TomatoHeaderSection
{
    public static function build(): void
    {
        TomatoForms::register((new self())->form());
        TomatoCMS::registerSection((new self())->section());
    }

    public function form(): Form
    {
        return Form::make()
            ->title(__('Header'))
            ->name(__('Header Section Form'))
            ->key('tomato_header')
            ->inputs([
                FormInput::make()
                    ->name('menu_id')
                    ->type('select')
                    ->is_from_table(true)
                    ->table_name('/admin/menus/api')
                    ->option_label('key')
                    ->option_value('key')
                    ->toArray()
            ]);
    }

    public function section(): Section
    {
        return Section::make()
            ->lock(true)
            ->key('tomato_header')
            ->icon('bx bx-circle')
            ->form('tomato_header')
            ->view('tomato-ecommerce::sections.headers.header')
            ->type('header');
    }
}
