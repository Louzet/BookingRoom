<?php

namespace App\Tests\Unitaires;

use App\Traits\TransliteratorSlugTrait;
use PHPUnit\Framework\TestCase;

class TransliteratorTest extends TestCase
{
    use TransliteratorSlugTrait;

    public function test_slugify_return_a_slug(): void
    {
        $slug = 'MK2 Grand Palais';

        $this->assertSame('mk2-grand-palais', $this->slugify($slug));
    }
}
