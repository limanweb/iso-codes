<?php 

namespace Limanweb\IsoCodes\Services;

class IsoCodesService 
{

    /**
     * Local cache
     * 
     * @var array
     */
    protected $localCache = [];

    /**
     * Configuration
     * 
     * @var array
     */
    protected $config;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->config = config('limanweb.iso_codes.config');
    }

    /**
     * Get a required section
     * 
     * @param string $section
     * @param string $path - A dot-path in section what will be returned.
     * @param string $locale
     * @return NULL|mixed
     */
    public function get(string $section, string $path = NULL, string $locale = NULL)
    {
        $locale = $locale ?? \App::getLocale();

        $data = self::getLocalCache($section, $locale)  // Read from local cache
            ?? self::getCache($section, $locale)        // or read from cache
            ?? self::getConfig($section, $locale);      // or read from config

        if (is_string($path)) {
            return \Arr::get($data, $path);
        }

        return $data;
    }

    /**
     * Get section from local cache
     * 
     * @param string $section
     * @param string $locale
     * @return NULL|array
     */
    protected function getLocalCache(string $section, string $locale)
    {
        if (!$this->config['use_local_cache']) {
            return null;
        }

        $cacheKey = self::getCacheKey($section, $locale);
        $data = $this->localCache[$cacheKey] ?? null;

        return empty($data) ? null : $data;
    }

    /**
     * Put section into local cache
     * 
     * @param string $section
     * @param string $locale
     * @param array $value
     */
    protected function putLocalCache(string $section, string $locale, array $value)
    {
        if (!$this->config['use_local_cache']) {
            return;
        }

        $cacheKey = self::getCacheKey($section, $locale);
        $this->localCache[$cacheKey] = $value;
    }

    /**
     * Get section from application cache
     * 
     * @param string $section
     * @param string $locale
     * @return NULL|array
     */
    protected function getCache(string $section, string $locale)
    {
        if (!$this->config['use_cache']) {
            return null;
        }

        $cacheKey = self::getCacheKey($section, $locale);
        $data = \Cache::get($cacheKey);
        if (is_array($data)) {
            self::putLocalCache($section, $locale, $data);
            return $data;
        }
        return null;
    }

    /**
     * Put section into application cache
     * 
     * @param string $section
     * @param string $locale
     * @param array $data
     */
    protected function putCache(string $section, string $locale, array $data)
    {
        if (!$this->config['use_cache']) {
            return;
        }

        $cacheKey = self::getCacheKey($section, $locale);
        \Cache::put($cacheKey, $data);
        self::putLocalCache($section, $locale, $data);
    }
 
    /**
     * Get section from config with translated attributes
     * 
     * @param string $section
     * @param string $locale
     * @throws \Exception
     * @return array|NULL
     */
    protected function getConfig(string $section, string $locale) 
    {
        // Load configuration of section
        $sectionConfig = $this->config['sections'][$section] ?? null;
        if (empty($sectionConfig)) {
            throw new \Exception(trans('limanweb/iso_codes::errors.section_config_not_exists', ['section' => $section]));
        }

        // Load data from config
        $data = [];
        $configData = config("{$sectionConfig['config_path']}");
        foreach ($configData as &$dataItem) {

            // Get translated fields for every item
            $transKey = "{$sectionConfig['trans_path']}.data.{$dataItem[$sectionConfig['trans_key']]}";
            $translatedFields = trans($transKey, [], $locale); 
            if (!is_array($translatedFields)) {
                $translatedFields = [];
            }

            // Merge translated fields
            $data[$dataItem[$sectionConfig['trans_key']]] = array_merge($dataItem, $translatedFields);
        }

        if (is_array($data)) {
            self::putCache($section, $locale, $data);
            return $data;
        }

        return null;
    }

    /**
     * Returns cache key
     * 
     * @param string $section
     * @param string $locale
     * @return string
     */
    private function getCacheKey(string $section, string $locale)
    {
        return "limanweb/iso_codes::{$section}.{$locale}";
    }
}