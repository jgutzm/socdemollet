<?php

namespace Tests;

use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Laravel\Dusk\Browser;
use Laravel\Dusk\TestCase as BaseTestCase;
use Tests\TestsHelper;

abstract class DuskTestCase extends BaseTestCase
{
    use CreatesApplication, TestsHelper;

    /**
     * Prepare for Dusk test execution.
     *
     * @beforeClass
     * @return void
     */
    public static function prepare()
    {
        static::startChromeDriver();

        Browser::macro('assertSeeErrors', function (array $fields) {
            foreach ($fields as $name => $errors) {
                foreach ((array) $errors as $message) {
                    $this->assertSeeIn(
                        "#field_{$name}.has-error .help-block", $message
                    );
                }
            }
        });
    }

    /**
     * Create the RemoteWebDriver instance.
     *
     * @return \Facebook\WebDriver\Remote\RemoteWebDriver
     */
    protected function driver()
    {
        return RemoteWebDriver::create(
            'http://localhost:9515', DesiredCapabilities::chrome()
        );
    }
}
