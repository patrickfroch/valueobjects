<?php

/**
 * @since       08.08.2022 - 11:16
 *
 * @author      Patrick Froch <info@easySolutionsIT.de>
 *
 * @see         http://easySolutionsIT.de
 *
 * @copyright   e@sy Solutions IT 2022
 * @license     LGPL
 */

declare(strict_types=1);

namespace Esit\Valueobjects\Tests\Url\Services\Validators;

use Esit\Valueobjects\Classes\Url\Services\Validators\UrlValidator;
use PHPUnit\Framework\TestCase;

class UrlValidatorTest extends TestCase
{


    /**
     * @var UrlValidator
     */
    private UrlValidator $validator;


    protected function setUp(): void
    {
        $this->validator = new UrlValidator();
    }


    public function testIsValidUrlReturnTrueIfUrlHasHttpSchema(): void
    {
        $url = 'http://exapmle.com';
        $this->assertTrue($this->validator->isValid($url));
    }


    public function testIsValidUrlReturnTrueIfUrlHasHttpsSchema(): void
    {
        $url = 'https://exapmle.com';
        $this->assertTrue($this->validator->isValid($url));
    }


    public function testIsValidUrlReturnTrueIfUrlHasFtpSchema(): void
    {
        $url = 'ftp://www.exapmle.com';
        $this->assertTrue($this->validator->isValid($url));
    }


    public function testIsValidUrlReturnTrueIfUrlHasSftpSchema(): void
    {
        $url = 'sftp://www.exapmle.com';
        $this->assertTrue($this->validator->isValid($url));
    }


    public function testIsValidUrlReturnTrueIfUrlHasSshSchema(): void
    {
        $url = 'ssh://www.exapmle.com';
        $this->assertTrue($this->validator->isValid($url));
    }


    public function testIsValidUrlReturnTrueIfUrlHasSmbSchema(): void
    {
        $url = 'smb://www.exapmle.com';
        $this->assertTrue($this->validator->isValid($url));
    }


    public function testIsValidUrlReturnTrueIfUrlHasASubdomain(): void
    {
        $url = 'https://www.exapmle.com';
        $this->assertTrue($this->validator->isValid($url));
    }


    public function testIsValidUrlReturnTrueIfUrlHasAClosingSlash(): void
    {
        $url = 'https://www.exapmle.com/';
        $this->assertTrue($this->validator->isValid($url));
    }


    public function testIsValidUrlReturnTrueIfUrlHasAPath(): void
    {
        $url = 'https://www.exapmle.com/page';
        $this->assertTrue($this->validator->isValid($url));
    }


    public function testIsValidUrlReturnTrueIfUrlHasAPage(): void
    {
        $url = 'https://www.exapmle.com/page.html';
        $this->assertTrue($this->validator->isValid($url));
    }


    public function testIsValidUrlReturnTrueIfUrlHasOneParameter(): void
    {
        $url = 'https://www.exapmle.com/page.html?paramOne=1';
        $this->assertTrue($this->validator->isValid($url));
    }


    public function testIsValidUrlReturnTrueIfUrlHasTwoParameters(): void
    {
        $url = 'https://www.exapmle.com/page.html?paramOne=1&paramTwo=2';
        $this->assertTrue($this->validator->isValid($url));
    }


    public function testIsValidUrlReturnTrueIfUrlHasAnchor(): void
    {
        $url = 'https://www.exapmle.com/page.html#jumpto?paramOne=1&paramTwo=2';
        $this->assertTrue($this->validator->isValid($url));
    }


    public function testIsValidUrlReturnTrueIfUrlHasNoSchemaAndForceSchemaIsFalse(): void
    {
        $url = 'www.exapmle.com';
        $this->assertTrue($this->validator->isValid($url));
    }


    public function testIsValidUrlReturnTrueIfUrlHasNoSubdomainAndForceSchemaIsFalse(): void
    {
        $url = 'exapmle.com';
        $this->assertTrue($this->validator->isValid($url));
    }


    public function testIsValidUrlReturnFalseIfUrlIsEmpty(): void
    {
        $url = '';
        $this->assertFalse($this->validator->isValid($url));
    }


    public function testIsValidUrlReturnFalseIfUrlHasNoTopLevelDomain(): void
    {
        $url = 'https://exapmle';
        $this->assertFalse($this->validator->isValid($url));
    }


    public function testIsValidUrlReturnFalseIfUrlHasTooManySlashes(): void
    {
        $url = 'https:///exapmle.com';
        $this->assertFalse($this->validator->isValid($url));
    }


    public function testIsValidUrlReturnFalseIfUrlHasDashOnEnd(): void
    {
        $url = 'https://exapmle.com-';
        $this->assertFalse($this->validator->isValid($url));
    }


    public function testIsValidUrlReturnFalseIfUrlHasDashOnStart(): void
    {
        $url = '-https://exapmle.com';
        $this->assertFalse($this->validator->isValid($url));
    }


    public function testIsValidUrlReturnFalseIfUrlHasDashOnStartOfDomain(): void
    {
        $url = 'https://-exapmle.com';
        $this->assertFalse($this->validator->isValid($url));
    }


    public function testIsValidUrlReturnFalseIfUrlHasOnlySchema(): void
    {
        $url = 'https://';
        $this->assertFalse($this->validator->isValid($url));
    }


    public function testIsValidUrlReturnFalseIfUrlHasOnlyOneWord(): void
    {
        $url = 'exapmle';
        $this->assertFalse($this->validator->isValid($url));
    }


    public function testIsValidUrlReturnTrueIfUrlHasHttpAndForceSchemaIsTrue(): void
    {
        $url = 'http://www.exapmle.com';
        $this->assertTrue($this->validator->isValid($url, true));
    }


    public function testIsValidUrlReturnTrueIfUrlHasHttpsAndForceSchemaIsTrue(): void
    {
        $url = 'https://www.exapmle.com';
        $this->assertTrue($this->validator->isValid($url, true));
    }


    public function testIsValidUrlReturnFalseIfUrlHasOnlySubdomainAndForceSchemaIsTrue(): void
    {
        $url = 'www.exapmle.com';
        $this->assertFalse($this->validator->isValid($url, true));
    }


    public function testIsValidUrlReturnFalseIfUrlHasOnlyDomainAndForceSchemaIsTrue(): void
    {
        $url = 'exapmle.com';
        $this->assertFalse($this->validator->isValid($url, true));
    }


    public function testIsValidUrlReturnFalseIfUrlHasDavAndDefaultSchemaIsSet(): void
    {
        $url = 'dav://www.exapmle.com';
        $this->assertFalse($this->validator->isValid($url, true));
    }


    public function testIsValidUrlReturnTrueIfUrlHasDavAndIndividualSchemaIsSet(): void
    {
        $url = 'dav://www.exapmle.com';
        $this->assertTrue($this->validator->isValid($url, true, 'dav'));
    }
}
