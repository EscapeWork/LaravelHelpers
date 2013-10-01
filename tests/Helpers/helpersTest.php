<?php
include_once('./src/Helpers/helpers.php');

class HelpersTest extends \PHPUnit_Framework_TestCase
{

    public function testToTimestampEmpty()
    {
        $this->assertNull(to_timestamp());
    }

    public function testToTimestamp()
    {
        $str = '01/01/2013 22:18';
        $this->assertEquals( to_timestamp($str), '2013-01-01 22:18');

        $str = '15/01/2013 22:18';
        $this->assertEquals( to_timestamp($str), '2013-01-15 22:18');

        $str = '15/01/2013 22:18';
        $this->assertNotEquals( to_timestamp($str), '15-01-2013 22:17');

        $str = '15/01/2013';
        $this->assertNotEquals( to_timestamp($str, 'd/m/Y', 'Y-m-d'), '15-01-2013');
    }

    public function testToTimestampShouldReturnNull()
    {
        $str = 'invalido';
        $this->assertNull( to_timestamp($str));
    }

    public function testToCharEmpty()
    {
        $this->assertNull(to_char(null));
    }

    public function testToChar()
    {
        $str = '2013-01-01 22:18';
        $this->assertEquals( to_char($str), '01/01/2013 22:18');

        $str = '2013-01-15 22:18';
        $this->assertEquals( to_char($str), '15/01/2013 22:18');
    }

    public function testToCharShouldReturnNull()
    {
        $str = 'invalid';
        $this->assertNull(to_char($str));
    }

    public function testRealToTimeEmpty()
    {
        $this->assertNull(real_to_time());
    }

    public function testRealToTime()
    {
        $str = 1;

        $this->assertEquals(real_to_time($str), '01:00');

        $str = 1.5;
        $this->assertEquals(real_to_time($str), '01:30');

        $str = 1.25;
        $this->assertEquals(real_to_time($str), '01:15');

        $str = 20000000;
        $this->assertEquals(real_to_time($str), '20000000:00');
    }


    public function testTimeToRealEmpty()
    {
        $this->assertNull(time_to_real());
        $this->assertNull(time_to_real(null));
    }

    public function testTimeToReal()
    {
        $hour = '21';
        $this->assertEquals(time_to_real($hour), $hour);

        $hour = '233:58';
        $real = '233.97';

        $this->assertEquals(time_to_real($hour), $real);
        $this->assertEquals(real_to_time($real), $hour);

        $hour = '21:20';
        $real = '21.33';
        $this->assertEquals(time_to_real($hour), $real);
        $this->assertEquals(real_to_time($real), $hour);
    }

    public function testTimestampReturnNull()
    {
        $this->assertNull( to_timestamp(null) );

        $a = '';
        $this->assertNull( to_timestamp($a) );
    }

    public function testToCharReturnNull()
    {
        $this->assertNull(to_char(null));
        $this->assertNull(to_char(''));
    }

    public function testToCharToReal()
    {
        $char = '1.000.000,00';
        $this->assertEquals(char_to_real($char), 1000000);

        $char = '1.000.000,55';
        $this->assertEquals(char_to_real($char), 1000000.55);

        $char = '1,000,200.00';
        $this->assertEquals(char_to_real($char, '.', ','), 1000200);
    }

    public function testToCharToRealShouldReturnNull()
    {
        $this->assertNull(char_to_real(null));
        $this->assertNull(char_to_real(''));
    }

    public function testTimeToRealReturnNull()
    {
        $this->assertNull(time_to_real(null));
    }

    public function testRealToTimeReturnNull()
    {
        $this->assertNull(real_to_time(null));
    }

    public function testFormatArrayKeysByField()
    {
        $array = array(
            0 => array('id' => 10),
            1 => array('id' => 11)
        );

        $newArray = formatArrayKeysByField($array);
        $this->assertTrue(isset($newArray[10]));
        $this->assertTrue(isset($newArray[11]));
    }

    public function testTruncateWorks()
    {
        $string   = 'quando um impressor desconhecido pegou uma bandeja de tipos e os embaralhou para fazer umquando um impressor desconhecido pegou uma bandeja de tipos e os embaralhou para fazer umquando um impressor desconhecido pegou uma bandeja de tipos e os embaralhou para fazer um';
        $truncate = truncate($string, 10);

        $this->assertTrue( strlen($truncate) == 12);
        $this->assertEquals( substr($truncate, -3), '...');
        $this->assertEquals( $truncate, 'quando um...');
    }


    public function testTruncateDoesntWork()
    {
        $string = 'quando um impressor desconhecido pegou uma bandeja de tipos e os embaralhou para fazer umquando um impressor desconhecido pegou uma bandeja de tipos e os embaralhou para fazer umquando um impressor desconhecido pegou uma bandeja de tipos e os embaralhou para fazer um';
        $this->assertFalse( strlen(truncate($string, 10)) == 10);
    }


}