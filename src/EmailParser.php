<?php

namespace OmegaVesko\EmailParser;

use Egulias\EmailValidator\EmailValidator;
use Egulias\EmailValidator\Validation\EmailValidation;
use Egulias\EmailValidator\Validation\RFCValidation;
use Psr\Log\LoggerInterface;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;
use Symfony\Component\Serializer\Serializer;

class EmailParser
{
    /**
     * @var LoggerInterface|null
     */
    private $logger;

    /**
     * @var EmailValidator
     */
    private $emailValidator;

    /**
     * @var EmailValidation
     */
    private $emailValidation;

    /**
     * @var EmailServiceInformation[]
     */
    private $emailServices;

    /**
     * EmailParser constructor.
     *
     * @param LoggerInterface|null $logger
     * @param EmailValidation|null $emailValidation
     */
    public function __construct(LoggerInterface $logger = null, EmailValidation $emailValidation = null)
    {
        $this->logger = $logger;
        $this->emailValidator = new EmailValidator();

        if ($emailValidation !== null) {
            $this->emailValidation = $emailValidation;
        } else {
            $this->emailValidation = new RFCValidation();
        }

        $serializer = new Serializer(
            [new GetSetMethodNormalizer(), new ArrayDenormalizer()],
            [new JsonEncoder()]
        );

        $this->emailServices = $serializer->deserialize(
            file_get_contents(__DIR__ . '/../email_services.json'),
            EmailServiceInformation::class . '[]',
            'json'
        );
    }

    /**
     * Parse a single email and return information about it.
     *
     * @param string $email
     * @return EmailInformation
     */
    public function parseEmail(string $email)
    {
        if (!$this->emailValidator->isValid($email, $this->emailValidation)) {
            throw new \InvalidArgumentException(
                "The email '$email' is invalid.",
                0,
                $this->emailValidator->getError()
            );
        }

        preg_match('/^(.+)@([^@]+)$/', $email, $matches);
        $localPart = $matches[1];
        $domain = $matches[2];

        $emailInformation = new EmailInformation($email);
        $emailInformation->setLocalPart($localPart);
        $emailInformation->setDomain($domain);

        $emailInformation->setEmailService($this->getEmailServiceInformationForDomain($domain));

        return $emailInformation;
    }

    /**
     * Convenience method to easily parse an array of emails.
     *
     * @param string[] $emails
     * @return EmailInformation[]
     */
    public function parseEmails(array $emails)
    {
        $output = [];

        foreach ($emails as $email) {
            try {
                $output[] = $this->parseEmail($email);
            } catch (\Throwable $t) {
                if ($this->logger !== null) {
                    $this->logger->error("Failed to parse email '$email'", ['exception' => $t]);
                }
            }
        }

        return $output;
    }

    private function getEmailServiceInformationForDomain(string $domain)
    {
        foreach ($this->emailServices as $service) {
            if (in_array($domain, $service->getDomains())) {
                return $service;
            }
        }

        return null;
    }
}