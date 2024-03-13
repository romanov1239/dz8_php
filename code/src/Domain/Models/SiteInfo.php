<?php

namespace Geekbrains\Application1\Domain\Models;

class SiteInfo
{
    private string $webServer;
    private string $phpVersion;
    private string $userAgent;

    /**
     * @param string $webServer
     * @param string $phpVersion
     * @param string $userAgent
     */
    public function __construct ()
    {
        $this -> webServer = $_SERVER['SERVER_SOFTWARE'];
        $this -> phpVersion = phpversion();
        $this -> userAgent = $_SERVER['HTTP_USER_AGENT'];

    }

    public function getWebServer (): string
    {
        return $this -> webServer;
    }

    public function getPhpVersion (): string
    {
        return $this -> phpVersion;
    }

    public function getUserAgent (): string
    {
        return $this -> userAgent;
    }
    public function getInfo (): array
    {
        return [
            'server' =>$this->getWebServer (),
          'phpVersion' =>$this->getPhpVersion (),
          'userAgent' =>$this->getUserAgent ()

        ];
    }

}