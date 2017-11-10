<?php 
class HotelTest extends PHPUnit_Framework_TestCase
{
	/** @test */
	public function sortHotel(){
		$hotel = new \App\Hotel;
		//handle curl ?!
        $this->assertEquals('Concorde Hotel',
        $hotel->sort("name"));
	}
}

?>