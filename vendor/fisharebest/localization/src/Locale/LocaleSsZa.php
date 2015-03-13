<?php namespace Fisharebest\Localization;

/**
 * Class LocaleSsZa
 *
 * @author        Greg Roach <fisharebest@gmail.com>
 * @copyright (c) 2015 Greg Roach
 * @license       GPLv3+
 */
class LocaleSsZa extends LocaleSs {
	/** {@inheritdoc} */
	public function territory() {
		return new TerritoryZa;
	}
}