<?php use Fisharebest\Webtrees\FontAwesome; ?>
<?php use Fisharebest\Webtrees\Functions\FunctionsEdit; ?>
<?php use Fisharebest\Webtrees\I18N; ?>

<h2 class="wt-page-title"><?= $title ?></h2>

<form class="wt-page-content" name="changefamform" method="post">
	<?= csrf_field() ?>

	<input type="hidden" name="ged" value="<?= e($tree->getName()) ?>">
	<input type="hidden" name="xref" value="<?= e($family->getXref()) ?>">

	<div class="form-group row">
		<label class="col-sm-3 col-form-label wt-page-options-label" for="HUSB">
			<?php if ($father !== null && $father->getSex() === 'M'): ?>
				<?= I18N::translate('Husband') ?>
			<?php elseif ($father !== null && $father->getSex() === 'F'): ?>
				<?= I18N::translate('Wife') ?>
			<?php else: ?>
				<?= I18N::translate('Spouse') ?>
			<?php endif ?>
		</label>
		<div class="col-sm-9 wt-page-options-value">
			<?= FunctionsEdit::formControlIndividual($tree, $father, ['id' => 'HUSB', 'name' => 'HUSB']) ?>
		</div>
	</div>

	<div class="form-group row">
		<label class="col-sm-3 col-form-label wt-page-options-label" for="WIFE">
			<?php if ($mother !== null && $mother->getSex() === 'M'): ?>
				<?= I18N::translate('Husband') ?>
			<?php elseif ($mother !== null && $mother->getSex() === 'F'): ?>
				<?= I18N::translate('Wife') ?>
			<?php else: ?>
				<?= I18N::translate('Spouse') ?>
			<?php endif ?>
		</label>
		<div class="col-sm-9 wt-page-options-value">
			<?= FunctionsEdit::formControlIndividual($tree, $mother, ['id' => 'WIFE', 'name' => 'WIFE']) ?>
		</div>
	</div>

	<?php foreach ($children as $n => $child): ?>
		<div class="form-group row">
			<label class="col-sm-3 col-form-label wt-page-options-label" for="CHIL<?= e($n) ?>">
				<?php if ($child !== null && $child->getSex() === 'M'): ?>
					<?= I18N::translate('Son') ?>
				<?php elseif ($child !== null && $child->getSex() === 'F'): ?>
					<?= I18N::translate('Daughter') ?>
				<?php else: ?>
					<?= I18N::translate('Child') ?>
				<?php endif ?>
			</label>
			<div class="col-sm-9 wt-page-options-value">
				<?= FunctionsEdit::formControlIndividual($tree, $child, ['id' => 'CHIL' . $n, 'name' => 'CHIL' . $n]) ?>
			</div>
		</div>
	<?php endforeach ?>

	<div class="form-group row">
		<label class="col-sm-3 col-form-label wt-page-options-label" for="CHIL<?= e(count($children) + 1) ?>">
			<?= I18N::translate('Child') ?>
		</label>
		<div class="col-sm-9 wt-page-options-value">
			<?= FunctionsEdit::formControlIndividual($tree, null, ['id' => 'CHIL' . (count($children) + 1), 'name' => 'CHIL' . (count($children) + 1)]) ?>
		</div>
	</div>

	<div class="form-group row">
		<div class="col-sm-3 wt-page-options-label">
		</div>
		<div class="col-sm-9 wt-page-options-value">
			<button class="btn btn-primary" type="submit">
				<?= FontAwesome::decorativeIcon('save') ?>
				<?= /* I18N: A button label. */
				I18N::translate('save') ?>
			</button>
			<a class="btn btn-secondary" href="<?= e($family->url()) ?>">
				<?= FontAwesome::decorativeIcon('cancel') ?>
				<?= /* I18N: A button label. */
				I18N::translate('cancel') ?>
			</a>
		</div>
	</div>
</form>
