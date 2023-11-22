<?php

namespace TomatoPHP\TomatoEcommerce\Services;

use TomatoPHP\TomatoEcommerce\Sections\TomatoCategorySection;
use TomatoPHP\TomatoEcommerce\Sections\TomatoFeatureSection;
use TomatoPHP\TomatoEcommerce\Sections\TomatoFooterSection;
use TomatoPHP\TomatoEcommerce\Sections\TomatoHeaderSection;
use TomatoPHP\TomatoEcommerce\Sections\TomatoHeroSection;
use TomatoPHP\TomatoEcommerce\Sections\TomatoProductsSection;
use TomatoPHP\TomatoCms\Facades\TomatoCMS;
use TomatoPHP\TomatoForms\Facades\TomatoForms;

class TomatoEcommerceSectionsBuilder
{
    public static function build(): void
    {
        TomatoHeaderSection::build();
        TomatoHeroSection::build();
        TomatoCategorySection::build();
        TomatoProductsSection::build();
        TomatoFeatureSection::build();
        TomatoFooterSection::build();

        //Create Section Forms
        TomatoForms::build();
        TomatoCMS::build();
    }
}
