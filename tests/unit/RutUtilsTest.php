<?php


use Freshwork\ChileanBundle\Validations\Rut;

class RutUtilsTest extends \Codeception\TestCase\Test
{
   /**
    * @var \UnitTester
    */
    protected $tester;

    protected function _before()
    {
    }

    protected function _after()
    {
    }

    // tests
    public function testMe()
    {
        $ruts = [
            'valid'    => ['11.111.111-1','111111111','11111112-K','11111112-k'],
            'invalid'  => ['11111112-9','12345-5','123-1','123.456.789-2']
        ];

        /***********************
         * TEST Rut::validate() with valid ruts
         *********************/
        $this->assertTrue(Rut::validate( $ruts['valid'][0] ),$ruts['valid'][0]);
        $this->assertTrue(Rut::validate( $ruts['valid'][1] ),$ruts['valid'][1]);
        $this->assertTrue(Rut::validate( $ruts['valid'][2] ),$ruts['valid'][2]);
        $this->assertTrue(Rut::validate( $ruts['valid'][3] ),$ruts['valid'][3]);

        $this->assertTrue( Rut::validate( '11.111.111','1' ) );
        $this->assertTrue( Rut::validate( '11111112','K' ) );

        /***********************
         * TEST Invalid without exception with invalid RUT.
         *********************/
        $this->assertFalse(Rut::validate( $ruts['invalid'][0] ),$ruts['invalid'][0]);

        /***********************
         * TEST Exceptions with invalid RUT.
         *********************/
        try{
            Rut::validate( $ruts['invalid'][1] );
            $this->assertTrue(false);
        }catch (\Exception $e){
            $this->assertEquals('Freshwork\ChileanBundle\Exceptions\InvalidFormatException',get_class($e));
        }

        try{
            Rut::validate( $ruts['invalid'][2] );
            $this->assertTrue(false);
        }catch (\Exception $e){
            $this->assertEquals('Freshwork\ChileanBundle\Exceptions\InvalidFormatException',get_class($e));
        }

        try{
            Rut::validate( $ruts['invalid'][3] );
            $this->assertTrue(false);
        }catch (\Exception $e){
            $this->assertEquals('Freshwork\ChileanBundle\Exceptions\InvalidFormatException',get_class($e));
        }

        /***********************
         * TEST Rut::getVerificationNumber()
         *********************/
        $this->assertEquals( Rut::getVerificationNumber('1.23.4.567-8-9')       , '9');
        $this->assertEquals( Rut::getVerificationNumber('1.23.4.567-8-K',true)  , 'K');

        /***********************
         * TEST Rut::format()
         *********************/
        $this->assertEquals(Rut::format('1.23.4.567-8-9'), '12.345.678-9','FORMAT_COMPLETE');
        $this->assertEquals(Rut::format('1.23.4.567-8-9',null,RUT::FORMAT_COMPLETE),     '12.345.678-9','FORMAT_COMPLETE');
        $this->assertEquals(Rut::format('1.23.4.567-8-9',null,RUT::FORMAT_WITH_DASH),    '12345678-9','FORMAT_WITH_DASH');
        $this->assertEquals(Rut::format('1.23.4.567-8-9',null,RUT::FORMAT_ESCAPED),      '123456789','FORMAT_ESCAPED');


        /***********************
         * TEST Rut::join()
         *********************/
        $this->assertEquals( Rut::join('12345678','9'), '12345678-9');

        /***********************
         * TEST Rut::normalize()
         *********************/
        $this->assertEquals( Rut::normalize('1.2.3.45.67.8-9'), '123456789');

    }

}