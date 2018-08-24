<?php use Fisharebest\Webtrees\Bootstrap4; ?>
<?php use Fisharebest\Webtrees\I18N; ?>

<ul class="nav nav-tabs" role="tablist">
	<li class="nav-item">
		<a class="nav-link active<?= empty($indilist) ? ' text-muted' : '' ?>" data-toggle="tab" role="tab" href="#individuals">
			<?= I18N::translate('Individuals') ?>
			<?= Bootstrap4::badgeCount($indilist) ?>
		</a>
	</li>
	<li class="nav-item">
		<a class="nav-link<?= empty($famlist) ? ' text-muted' : '' ?>" data-toggle="tab" role="tab" href="#families">
			<?= I18N::translate('Families') ?>
			<?= Bootstrap4::badgeCount($famlist) ?>
		</a>
	</li>
</ul>
<div class="tab-content">
	<div class="tab-pane fade show active" role="tabpanel" id="individuals">
		<?php if (empty($indilist)): ?>
			<p><?= I18N::translate('No results found.') ?></p>
		<?php else: ?>
			<?= view('lists/individuals-table', [
			'individuals' => $indilist,
			'sosa'        => false,
			'tree'        => $tree,
			]) ?>
		<?php endif ?>
	</div>

	<div class="tab-pane fade" role="tabpanel" id="families">
		<?php if (empty($famlist)): ?>
			<p><?= I18N::translate('No results found.') ?></p>
		<?php else: ?>
			<?= view('lists/families-table', [
				'families' => $famlist,
			]) ?>
		<?php endif ?>
	</div>
</div>
