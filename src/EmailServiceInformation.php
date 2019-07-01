<?php

namespace OmegaVesko\EmailParser;

class EmailServiceInformation
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var string[]
     */
    private $domains;

    /**
     * @var string
     */
    private $webmailUrl;

    /**
     * EmailServiceInformation constructor.
     * @param string $name
     * @param string[] $domains
     * @param string $webmailUrl
     */
    public function __construct(string $name, array $domains, string $webmailUrl)
    {
        $this->name = $name;
        $this->domains = $domains;
        $this->webmailUrl = $webmailUrl;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string[]
     */
    public function getDomains(): array
    {
        return $this->domains;
    }

    /**
     * @return string
     */
    public function getWebmailUrl(): string
    {
        return $this->webmailUrl;
    }
}