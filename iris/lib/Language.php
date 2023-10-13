<?php
namespace Iris;

/**
 * Simple implementation of i18n and l10n
 */
class Language
{

    public $locale = "";

    public $l10ValuesArray = [];

    private $localeFolder = __DIR__ . '/../language/';

    function __construct($locale = 'en')
    {
        $this->setLocale($locale);
    }

    /**
     * Get the language file based on the locale.
     *
     * @param string $locale
     * @throws \Exception
     * @return string
     */
    public function getLocaleFilePath($locale)
    {
        $l10nFile = $this->localeFolder . 'lang-' . $locale . '.php';
        if (file_exists($l10nFile)) {
            return $l10nFile;
        } else {
            throw new \Exception('Error 1201: Localization language file not found for locale ' . $this->locale);
        }
    }

    /**
     * Set the locale.
     * The default language is English.
     *
     * @param string $locale
     *            ISO 639-1 2-character language code (e.g. French is "fr")
     */
    public function setLocale($locale = 'en')
    {
        $this->locale = $locale;
        $localeFile = $this->getLocaleFilePath($locale);
        require $localeFile;
        // $LANG is the name of the array present in the language localization file
        // it gets included in the above if-else part
        $this->l10ValuesArray = $LANG;
    }

    /**
     * Get the l10n string value for the key
     * with respect to the currently-selected language.
     * If the key is not present, will check in 'en'
     * lang file as fallback.
     * If 'en' file also does not contain the key, then
     * the key itself is returned as value
     *
     * @return string l10n value matching the received key
     */
    public function value($key)
    {
        // If key found return value else
        // If not english load english and return
        // Else return key
        $l10Value = $key;
        if (array_key_exists($key, $this->l10ValuesArray)) {
            $l10Value = $this->l10ValuesArray[$key];
        } else if (! $this->locale != 'en') {
            $existingLocale = $this->locale;
            $this->setLocale('en');
            if (array_key_exists($key, $this->l10ValuesArray)) {
                $l10Value = $this->l10ValuesArray[$key];
            }
            $this->setLocale($existingLocale);
        }
        return $l10Value;
    }

    function getLocale()
    {
        return $this->locale;
    }
}
