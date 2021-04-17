<?php

namespace OmegaVesko\EmailParser;

class EmailInformation
{
    public string $email;
    public string $localPart;
    public string $domain;
    public ?EmailServiceInformation $emailService;

    public function __construct(string $email)
    {
        $this->email = $email;
    }
}
