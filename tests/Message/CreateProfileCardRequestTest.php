<?php

namespace Omnipay\Beanstream\Message;

use Omnipay\Tests\TestCase;

class CreateProfileCardRequestTest extends TestCase
{
    public function setUp()
    {
        $this->request = new CreateProfileCardRequest($this->getHttpClient(), $this->getHttpRequest());
        $this->request->initialize();
    }

    public function testEndpoint()
    {
        $this->assertSame($this->request, $this->request->setProfileId('1'));
        $this->assertSame('1', $this->request->getProfileId());
        $this->assertSame('https://www.beanstream.com/api/v1/profiles/' . $this->request->getProfileId(). '/cards', $this->request->getEndpoint());
    }

    public function testCard()
    {
        $card = $this->getValidCard();
        $this->assertSame($this->request, $this->request->setCard($card));
        $data = $this->request->getData();
        $this->assertSame($card['number'], $data['number']);
        $this->assertSame($card['cvv'], $data['cvd']);
        $this->assertSame(sprintf("%02d", $card['expiryMonth']), $data['expiry_month']);
        $this->assertSame(substr($card['expiryYear'], -2), $data['expiry_year']);
        $this->assertSame($card['firstName'] . ' ' . $card['lastName'], $data['name']);
    }

    public function testHttpMethod()
    {
        $this->assertSame('POST', $this->request->getHttpMethod());
    }
}
