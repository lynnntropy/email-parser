<?php

use OmegaVesko\EmailParser\EmailInformation;
use OmegaVesko\EmailParser\EmailParser;
use PHPUnit\Framework\TestCase;

class EmailParserTest extends TestCase
{
    public function testParseSingleEmail()
    {
        $parser = new EmailParser();

        $info = $parser->parseEmail("omegavesko@gmail.com");

        $this->assertEquals("omegavesko@gmail.com", $info->email);
        $this->assertEquals("omegavesko", $info->localPart);
        $this->assertEquals("gmail.com", $info->domain);
        $this->assertNotEmpty($info->emailService);
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

        $this->assertNotEmpty($info->email);
        $this->assertNotEmpty($info->localPart);
        $this->assertNotEmpty($info->domain);

        if ($shouldFindService) {
            $this->assertNotNull($info->emailService);
        } else {
            $this->assertNull($info->emailService);
        }
    }

    public function emailProvider()
    {
        return [
            ["iojdioejfd@gmail.com", true],
            ["iojdioejfd@googlemail.com", true],
            ["test@yahoo.com", true],
            ["test@nonexistent.test", false],
        ];
    }

    public function testParseEmails()
    {
        $parser = new EmailParser();

        $emails = $parser->parseEmails([
            "omegavesko@gmail.com",
            "test@test.dev",
            "asopdkasopkd@ekfewfeef",
            "asdasdasdasdasd",
        ]);

        $this->assertCount(3, $emails);
        $this->assertContainsOnlyInstancesOf(EmailInformation::class, $emails);
    }
}
