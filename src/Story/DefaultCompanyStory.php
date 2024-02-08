<?php

namespace App\Story;

use App\Factory\CompanyFactory;
use Zenstruck\Foundry\Story;

/**
 *
 */
final class DefaultCompanyStory extends Story
{
    /**
     * @return void
     */
    public function build(): void
    {
        CompanyFactory::createMany(10);
    }
}
