<?php namespace Fisharebest\Localization;

/**
 * Class LocaleFrTg
 *
 * @author        Greg Roach <fisharebest@gmail.com>
 * @copyright (c) 2015 Greg Roach
 * @license       GPLv3+
 */
class LocaleFrTg extends LocaleFr {
	/** {@inheritdoc} */
	public function territory() {
		return new TerritoryTg;
	}
}