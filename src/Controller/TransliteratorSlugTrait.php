<?php
namespace App\Controller;

use Behat\Transliterator\Transliterator;

trait TransliteratorSlugTrait
{

    /**
     * Permet de genérer un slug à partir d'un string
     * @param string $text
     * @return string
     */
    public function slugify(string $text)
    {
        return Transliterator::transliterate($text);
    }

}