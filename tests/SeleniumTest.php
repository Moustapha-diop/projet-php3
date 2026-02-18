<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\WebDriverBy;

class SeleniumTest extends TestCase
{
    protected $driver;
    // protected $baseUrl = 'http://127.0.0.1:8000';

// Après (pour GitHub Actions / Docker)
    protected $baseUrl = 'http://host.docker.internal:8000';
    // Cette fonction s'exécute AVANT chaque test
    protected function setUp(): void
    {
        $host = 'http://localhost:4444/wd/hub';
        $capabilities = DesiredCapabilities::chrome();
        
        // Options pour le mode "headless" (sans fenêtre, requis pour le DevOps/CI)
        $capabilities->setCapability('goog:chromeOptions', [
            'args' => ['--headless', '--no-sandbox', '--disable-dev-shm-usage']
        ]);

        $this->driver = RemoteWebDriver::create($host, $capabilities);
    }

    // --- TES TESTS COMMENCENT ICI ---

    public function testIndexContent()
    {
        $this->driver->get($this->baseUrl);

        // 1. Vérifier le titre de l'onglet
        $this->assertEquals('Mon App PHP DevOps', $this->driver->getTitle());

        // 2. Vérifier le titre H1 dans la page
        $titleH1 = $this->driver->findElement(WebDriverBy::id('main-title'))->getText();
        $this->assertEquals('Bienvenue sur mon projet Docker', $titleH1);

        // 3. Vérifier que l'image 1.png est présente
        $image = $this->driver->findElement(WebDriverBy::id('logo'));
        $this->assertStringContainsString('1.png', $image->getAttribute('src'));
    }

    // --- TES TESTS S'ARRÊTENT ICI ---

    // Cette fonction s'exécute APRÈS chaque test
    protected function tearDown(): void
    {
        if ($this->driver) {
            $this->driver->quit();
        }
    }
}