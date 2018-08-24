<?php use Fisharebest\Webtrees\I18N; ?>
<?php use Fisharebest\Webtrees\View; ?>

<h2 class="wt-page-title">
	<?= $title ?>
</h2>

<div class="wt-page-content wt-chart wt-statistics-chart" id="statistics-tabs">
	<ul class="nav nav-tabs" role="tablist">
		<li class="nav-item">
			<a class="nav-link" href="#individual-statistics" data-toggle="tab" data-href="<?= e(route('statistics-individuals', ['ged' => $tree->getName()])) ?>" role="tab">
				<?= I18N::translate('Individuals') ?>
			</a>
		</li>
		<li class="nav-item">
			<a class="nav-link" href="#family-statistics" data-toggle="tab" data-href="<?= e(route('statistics-families', ['ged' => $tree->getName()])) ?>" role="tab">
				<?= I18N::translate('Families') ?>
			</a>
		</li>
		<li class="nav-item">
			<a class="nav-link" href="#other-statistics" data-toggle="tab" data-href="<?= e(route('statistics-other', ['ged' => $tree->getName()])) ?>" role="tab">
				<?= I18N::translate('Others') ?>
			</a>
		</li>
		<li class="nav-item">
			<a class="nav-link" href="#custom-statistics" data-toggle="tab" data-href="<?= e(route('statistics-options', ['ged' => $tree->getName()])) ?>" role="tab">
				<?= I18N::translate('Custom') ?>
			</a>
		</li>
	</ul>

	<div class="tab-content">
		<div class="tab-pane fade wt-ajax-load" role="tabpanel" id="individual-statistics"></div>
		<div class="tab-pane fade wt-ajax-load" role="tabpanel" id="family-statistics"></div>
		<div class="tab-pane fade wt-ajax-load" role="tabpanel" id="other-statistics"></div>
		<div class="tab-pane fade wt-ajax-load" role="tabpanel" id="custom-statistics"></div>
	</div>
</div>

<?php View::push('javascript') ?>
<script>
  "use strict";

  // Bootstrap tabs - load content dynamically using AJAX
  $('a[data-toggle="tab"][data-href]').on('show.bs.tab', function () {
    $(this.getAttribute('href') + ':empty').load($(this).data('href'));
  });

  // If the URL contains a fragment, then activate the corresponding tab.
  // Use a prefix on the fragment, to prevent scrolling to the element.
  var target = window.location.hash.replace("tab-", "");
  var tab    = $("#statistics-tabs .nav-link[href='" + target + "']");
  // If not, then activate the first tab.
  if (tab.length === 0) {
    tab = $("#statistics-tabs .nav-link:first");
  }
  tab.tab("show");

  // If the user selects a tab, update the URL to reflect this
  $('#statistics-tabs a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
    window.location.hash = "tab-" + e.target.href.substring(e.target.href.indexOf('#') + 1);
  });
</script>
<?php View::endpush() ?>
