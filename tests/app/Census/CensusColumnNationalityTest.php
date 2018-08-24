<?php

/**
 * webtrees: online genealogy
 * Copyright (C) 2018 webtrees development team
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
 */
namespace Fisharebest\Webtrees\Census;

use Fisharebest\Webtrees\Date;
use Mockery;

/**
 * Test harness for the class CensusColumnNationality
 */
class CensusColumnNationalityTest extends \PHPUnit\Framework\TestCase
{
    /**
     * Delete mock objects
     */
    public function tearDown()
    {
        Mockery::close();
    }

    /**
     * Get place mock.
     *
     * @param string $place Gedcom Place
     *
     * @return \Fisharebest\Webtrees\Place
     */
    private function getPlaceMock($place)
    {
        $placeMock = Mockery::mock('\Fisharebest\Webtrees\Place');
        $placeMock->shouldReceive('getGedcomName')->andReturn($place);

        return $placeMock;
    }

    /**
     * @covers \Fisharebest\Webtrees\Census\CensusColumnNationality
     * @covers \Fisharebest\Webtrees\Census\AbstractCensusColumn
     */
    public function testNoBirthPlace()
    {
        $individual = Mockery::mock('Fisharebest\Webtrees\Individual');
        $individual->shouldReceive('getBirthPlace')->andReturn($this->getPlaceMock(''));
        $individual->shouldReceive('getFacts')->with('IMMI|EMIG|NATU', true)->andReturn([]);

        $census = Mockery::mock('Fisharebest\Webtrees\Census\CensusInterface');
        $census->shouldReceive('censusPlace')->andReturn('Deutschland');

        $column = new CensusColumnNationality($census, '', '');

        $this->assertSame('Deutsch', $column->generate($individual, $individual));
    }

    /**
     * @covers \Fisharebest\Webtrees\Census\CensusColumnNationality
     * @covers \Fisharebest\Webtrees\Census\AbstractCensusColumn
     */
    public function testPlaceCountry()
    {
        $individual = Mockery::mock('Fisharebest\Webtrees\Individual');
        $individual->shouldReceive('getBirthPlace')->andReturn($this->getPlaceMock('Australia'));
        $individual->shouldReceive('getFacts')->with('IMMI|EMIG|NATU', true)->andReturn([]);

        $census = Mockery::mock('Fisharebest\Webtrees\Census\CensusInterface');
        $census->shouldReceive('censusPlace')->andReturn('England');

        $column = new CensusColumnNationality($census, '', '');

        $this->assertSame('Australia', $column->generate($individual, $individual));
    }

    /**
     * @covers \Fisharebest\Webtrees\Census\CensusColumnNationality
     * @covers \Fisharebest\Webtrees\Census\AbstractCensusColumn
     */
    public function testBritish()
    {
        $individual = Mockery::mock('Fisharebest\Webtrees\Individual');
        $individual->shouldReceive('getBirthPlace')->andReturn($this->getPlaceMock('London, England'));
        $individual->shouldReceive('getFacts')->with('IMMI|EMIG|NATU', true)->andReturn([]);

        $census = Mockery::mock('Fisharebest\Webtrees\Census\CensusInterface');
        $census->shouldReceive('censusPlace')->andReturn('England');

        $column = new CensusColumnNationality($census, '', '');

        $this->assertSame('British', $column->generate($individual, $individual));
    }

    /**
     * @covers \Fisharebest\Webtrees\Census\CensusColumnNationality
     * @covers \Fisharebest\Webtrees\Census\AbstractCensusColumn
     */
    public function testEmigrated()
    {
        $place1 = Mockery::mock('Fisharebest\Webtrees\Place');
        $place1->shouldReceive('getGedcomName')->andReturn('United States');

        $fact1 = Mockery::mock('Fisharebest\Webtrees\Fact');
        $fact1->shouldReceive('getPlace')->andReturn($place1);
        $fact1->shouldReceive('getDate')->andReturn(new Date('1855'));

        $place2 = Mockery::mock('Fisharebest\Webtrees\Place');
        $place2->shouldReceive('getGedcomName')->andReturn('Australia');

        $fact2 = Mockery::mock('Fisharebest\Webtrees\Fact');
        $fact2->shouldReceive('getPlace')->andReturn($place2);
        $fact2->shouldReceive('getDate')->andReturn(new Date('1865'));

        $individual = Mockery::mock('Fisharebest\Webtrees\Individual');
        $individual->shouldReceive('getBirthPlace')->andReturn($this->getPlaceMock('London, England'));
        $individual->shouldReceive('getFacts')->with('IMMI|EMIG|NATU', true)->andReturn([
            $fact1,
            $fact2,
        ]);

        $census = Mockery::mock('Fisharebest\Webtrees\Census\CensusInterface');
        $census->shouldReceive('censusPlace')->andReturn('England');
        $census->shouldReceive('censusDate')->andReturn('01 JUN 1860');

        $column = new CensusColumnNationality($census, '', '');

        $this->assertSame('United States', $column->generate($individual, $individual));
    }
}
