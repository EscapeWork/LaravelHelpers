<?php

include_once('./src/Helpers/helpers.php');


class helpersTest extends \PHPUnit_Framework_TestCase {


    public function testToTimestamp()
    {
        $str = '01/01/2013 22:18';
        $this->assertEquals( to_timestamp($str), '2013-01-01 22:18');

        $str = '15/01/2013 22:18';
        $this->assertEquals( to_timestamp($str), '2013-01-15 22:18');

        $str = '15/01/2013 22:18';
        $this->assertNotEquals( to_timestamp($str), '15-01-2013 22:17');
    }


    public function testToChar()
    {
        $str = '2013-01-01 22:18';
        $this->assertEquals( to_char($str), '01/01/2013 22:18');

        $str = '2013-01-15 22:18';
        $this->assertEquals( to_char($str), '15/01/2013 22:18');
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


    public function testTimeConversion()
    {
        $hour = '233:58';
        $real = '233.97';

        $this->assertEquals(time_to_real($hour), $real);
        $this->assertEquals(real_to_time($real), $hour);

        $hour = '21:20';
        $real = '21.33';
        $this->assertEquals(time_to_real($hour), $real);
        $this->assertEquals(real_to_time($real), $hour);

    }

}