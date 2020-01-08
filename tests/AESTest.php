<?php

namespace Test\CQApi;

use JavaReact\CQApi\Tools\AES;

/**
 * Class AESTest
 * @package Test\CQApi
 */
class AESTest extends BaseTest
{

    /**
     * 测试解密
     */
    public function testDecrypt()
    {
        $text = AES::decrypt('2SilothZONRO6H/W/j34DPs3C7zoFW58Hp1q7iskXmhuexmPudtdf0IohvKCuFrG', 'key', 'iv');
        $this->assertSame('1ac5ec57-d5e5-4f92-8089-71d5aeeec346', $text);
    }

}