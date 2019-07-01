<?php

namespace OmegaVesko\EmailParser;

class EmailInformation
{
    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $localPart;

    /**
     * @var string
     */
    private $domain;

    /**
     * @var EmailServiceInformation|null;
     */
    private $emailService;

    /**
     * EmailInformation constructor.
     * @param string $email
     */
    public function __construct(string $email)
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getLocalPart(): string
    {
        return $this->localPart;
    }

    /**
     * @param string $localPart
     */
    public function setLocalPart(string $localPart): void
    {
        $this->localPart = $localPart;
    }

    /**
     * @return string
     */
    public function getDomain(): string
    {
        return $this->domain;
    }

    /**
     * @param string $domain
     */
    public function setDomain(string $domain): void
    {
        $this->domain = $domain;
    }

    /**
     * @return EmailServiceInformation|null
     */
    public function getEmailService(): ?EmailServiceInformation
    {
        return $this->emailService;
    }

    /**
     * @param EmailServiceInformation|null $emailService
     */
    public function setEmailService(?EmailServiceInformation $emailService): void
    {
        $this->emailService = $emailService;
    }
}