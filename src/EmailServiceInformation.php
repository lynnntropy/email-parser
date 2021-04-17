<?php

namespace OmegaVesko\EmailParser;

class EmailServiceInformation
{
    public string $name;
    /** @var string[] */
    public array $domains;
    public string $webmailUrl;

    /**
     * @param string $name
     * @param string[] $domains
     * @param string $webmailUrl
     */
    public function __construct(
        string $name,
        array $domains,
        string $webmailUrl
    ) {
        $this->name = $name;
        $this->domains = $domains;
        $this->webmailUrl = $webmailUrl;
    }
}
