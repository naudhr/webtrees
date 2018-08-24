<?php use Fisharebest\Webtrees\I18N; ?>

<?php foreach ($records as $record): ?>
	<a href="<?= e($record->url()) ?>" class="list_item name2">
		<?= $record->getFullName() ?>
	</a>
	<div class="indent mb-1">
		<?php if ($record->lastChangeTimestamp() !== ''): ?>
			<?php if ($show_user): ?>
				<?= /* I18N: [a record was] Changed on <date/time> by <user> */I18N::translate('Changed on %1$s by %2$s', $record->lastChangeTimestamp(), e($record->lastChangeUser())) ?>
			<?php else: ?>
				<?= /* I18N: [a record was] Changed on <date/time> */ I18N::translate('Changed on %1$s', $record->lastChangeTimestamp()) ?>
			<?php endif ?>
		<?php endif ?>
	</div>
<?php endforeach ?>
