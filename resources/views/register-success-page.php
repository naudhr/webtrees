<?php use Fisharebest\Webtrees\I18N; ?>

<h2 class="wt-page-title">
	<?= $title ?>
</h2>

<div class="wt-page-content">
	<p>
		<?= I18N::translate('Hello %s…<br>Thank you for your registration.', e($user->getRealName())) ?>
	</p>

	<p>
		<?= I18N::translate('We will now send a confirmation email to the address <b>%s</b>. You must verify your account request by following instructions in the confirmation email. If you do not confirm your account request within seven days, your application will be rejected automatically. You will have to apply again.<br><br>After you have followed the instructions in the confirmation email, the administrator still has to approve your request before your account can be used.<br><br>To sign in to this website, you will need to know your username and password.', $user->getEmail()) ?>
	</p>
</div>
