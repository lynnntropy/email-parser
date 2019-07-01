<?php


use OmegaVesko\EmailParser\EmailInformation;
use OmegaVesko\EmailParser\EmailParser;
use PHPUnit\Framework\TestCase;

class EmailParserTest extends TestCase
{
    public function testParseSingleEmail()
    {
        $parser = new EmailParser();

        $info = $parser->parseEmail('omegavesko@gmail.com');

        $this->assertEquals('omegavesko@gmail.com', $info->getEmail());
        $this->assertEquals('omegavesko', $info->getLocalPart());
        $this->assertEquals('gmail.com', $info->getDomain());
        $this->assertNotEmpty($info->getEmailService());
    }

    /**
     * @dataProvider emailProvider
     *
     * @param string $email
     * @param bool $shouldFindService
     */
    public function testParseEmail(string $email, bool $shouldFindService)
    {
        $parser = new EmailParser();

        $info = $parser->parseEmail($email);

        $this->assertNotEmpty($info->getEmail());
        $this->assertNotEmpty($info->getLocalPart());
        $this->assertNotEmpty($info->getDomain());

        if ($shouldFindService) {
            $this->assertNotNull($info->getEmailService());
        } else {
            $this->assertNull($info->getEmailService());
        }
    }

    public function emailProvider()
    {
        return [
            ['iojdioejfd@gmail.com', true],
            ['iojdioejfd@googlemail.com', true],
            ['test@yahoo.com', true],
            ['test@nonexistent.test', false]
        ];
    }

    public function testParseEmails()
    {
        $parser = new EmailParser();

        $emails = $parser->parseEmails([
            'omegavesko@gmail.com',
            'test@test.dev',
            'asopdkasopkd@ekfewfeef'
        ]);

        $this->assertCount(2, $emails);
        $this->assertContainsOnlyInstancesOf(EmailInformation::class, $emails);
    }
}