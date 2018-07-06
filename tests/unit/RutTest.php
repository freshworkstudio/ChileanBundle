<?php


use Freshwork\ChileanBundle\Rut;

class RutTest extends \Codeception\TestCase\Test
{
    use \Codeception\Specify;
    /**
     * @var \UnitTester
     */
    protected $tester;
    private $ruts;

    // tests
    public function testValidation()
    {
        $this->ruts = [
            'valid'    => ['11.111.111-1','111111111','11111112-K','11111112-k'],
            'invalid'  => ['11111112-9','17601065fail-7','123-1','123.456.789-2','11.111.111-L']
        ];

        /***********************
         * TEST Rut::validate() with valid ruts
         *********************/
        $this->specify('it validates valid ruts as static', function () {
            foreach ($this->ruts['valid'] as $valid_rut) {
                $this->assertTrue(Rut::parse($valid_rut)->validate());
            }

            $this->assertTrue(Rut::set('11.111.111', '1')->validate());
            $this->assertTrue(Rut::set('11111112', 'K')->validate());
            $this->assertTrue(Rut::set('11111112', 'K')->isValid());
        });

        $this->specify('it validates as object', function () {
            foreach ($this->ruts['valid'] as $valid_rut) {
                $this->assertTrue((new Rut())->parse($valid_rut)->validate());
            }

            $this->assertTrue((new Rut('11111112', 'K'))->validate());
            $this->assertTrue((new Rut('11111112', 'K'))->isValid());
        });


        /***********************
         * TEST Invalid without exception with invalid RUT.
         *********************/
        $this->specify('it validates valid ruts as static', function () {
            $this->assertFalse(Rut::parse($this->ruts['invalid'][0])->validate());
        });

        /***********************
         * TEST Exceptions with invalid RUT.
         *********************/
        $this->specify('test exceptions with invalid RUTs', function () {
            foreach ($this->ruts['invalid'] as $invalid_rut) {
                try {
                    Rut::parse($invalid_rut)->validate();
                } catch (\Exception $e) {
                    $this->assertEquals('Freshwork\ChileanBundle\Exceptions\InvalidFormatException', get_class($e));
                }
            }
        });


        /***********************
         * TEST  invalid RUT without exceptions.
         *********************/
        $this->specify('Validate invalid RUT on quit mode', function () {
            $this->assertFalse(Rut::parse($this->ruts['invalid'][1])->quiet()->validate());
            $this->assertFalse(Rut::parse($this->ruts['invalid'][2])->quiet()->validate());
            $this->assertFalse(Rut::parse($this->ruts['invalid'][3])->quiet()->validate());
        });

        /***********************
         * TEST Rut::calculateVerificationNumber()
         *********************/
        $this->specify('Test calculateVerificationNumber', function () {
            $this->assertEquals((new Rut('11.111.111'))->calculateVerificationNumber(), '1');
            $this->assertEquals(Rut::parse('1.23.4.567-8-K')->calculateVerificationNumber(), '5');
        });

        /***********************
         * TEST Rut::format()
         *********************/
        $this->specify('Test format function', function () {
            $this->assertEquals(Rut::parse('1.23.4.567-8-9')->format(), '12.345.678-9', 'FORMAT_COMPLETE');
            $this->assertEquals(Rut::parse('1.23.4.567-8-K')->format(Rut::FORMAT_COMPLETE), '12.345.678-K', 'FORMAT_COMPLETE');
            $this->assertEquals(Rut::parse('1.23.4.567-8-9')->format(Rut::FORMAT_WITH_DASH), '12345678-9', 'FORMAT_WITH_DASH');
            $this->assertEquals(Rut::parse('1.23.4.567-8-9')->format(Rut::FORMAT_ESCAPED), '123456789', 'FORMAT_ESCAPED');
        });

        /***********************
         * TEST Rut::join()
         *********************/
        $this->specify('Test join function', function () {
            $this->assertEquals(Rut::set('12345678', '9')->join(), '12345678-9');
        });
        /***********************
         * TEST Rut::normalize()
         *********************/
        $this->specify('Test normalize() function', function () {
            $this->assertEquals(Rut::parse('1.2.3.45.67.8-9')->normalize(), '123456789');
        });

        $this->specify('It fixes an invalid RUT', function () {
            $this->assertEquals(Rut::parse($this->ruts['invalid'][0])->fix()->normalize(), '11111112K');
            $this->assertEquals(Rut::parse($this->ruts['invalid'][0])->fix()->format(), '11.111.112-K');
            $this->assertTrue(Rut::parse($this->ruts['invalid'][0])->fix()->validate());
            $this->assertTrue(Rut::parse('12.345.678-9')->fix()->isValid());
        });

        $this->specify('It returns the RUT as an array', function () {
            $this->assertEquals(Rut::parse($this->ruts['valid'][0])->toArray(), ['11111111', '1']);
            $this->assertEquals(Rut::parse($this->ruts['valid'][2])->toArray(), ['11111112', 'K']);
        });

        $this->specify('It uses the setters', function () {
            $this->assertEquals(Rut::set()->number('12.345.678')->vn('5')->format(), '12.345.678-5');
        });
    }
}
