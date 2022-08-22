<form id="upload-form" action="<?= base_url('/upload/do-upload') ?>" method="POST" enctype="multipart/form-data">
	<div class="row">
		<div class="col-12">

			<div class="form-group mb-3">
				<label for="name"><?= lang('Dashboard.title') ?></label>
				<input type="text" name="name" id="name" class="form-control" required />
			</div>

			<div class="form-group mb-3">
				<label for="battle-size" class="form-label"><?= lang('Dashboard.battle_size') ?></label>
				<select name="battle-size" id="battle-size" class="selectpicker form-control" data-live-search="true" title="<?= lang('Dashboard.nothing_selected') ?>">
					<?php foreach ($battleSizes as $option) : ?>
						<option value="<?= $option->id ?>"><?= $option->name ?></option>
					<?php endforeach; ?>
				</select>
			</div>

			<div class="form-group mb-3">
				<label for="game-type" class="form-label"><?= lang('Dashboard.game_type') ?></label>
				<select name="game-type" id="game-type" class="selectpicker form-control" data-live-search="true" title="<?= lang('Dashboard.nothing_selected') ?>">
					<?php foreach ($gameTypes as $option) : ?>
						<option value="<?= $option->id ?>"><?= $option->name ?></option>
					<?php endforeach; ?>
				</select>
			</div>

			<div class="form-group mb-3">
				<label for="armies" class="form-label"><?= lang('Dashboard.armies') ?></label>
				<select name="armies" id="armies" class="filter selectpicker form-control" multiple data-selected-text-format="count" data-actions-box="true" data-select-all-text="<?= lang('Dashboard.select_all') ?>" data-deselect-all-text="<?= lang('Dashboard.deselect_all') ?>" data-count-selected-text="<?= lang('Dashboard.count_selected') ?>" data-live-search="true" title="<?= lang('Dashboard.nothing_selected') ?>">
					<?php foreach ($armies as $option) : ?>
						<option value="<?= $option->id ?>" data-subtext="(<?= $option->total ?>)" <?= $option->total > 0 ? '' : "disabled" ?>><?= $option->name ?></option>
					<?php endforeach; ?>
				</select>
			</div>

			<div class="mb-3">
				<label for="file" class="form-label"><?= lang('Upload.file_long') ?></label>
				<input class="form-control" type="file" accept="text/html,application/pdf" name="file" id="file" required>
			</div>

			<div class="row">
				<div class="col-lg-6 mt-4">
					<button type="submit" class="btn btn-primary form-control"><?= lang('Upload.upload') ?></button>
				</div>
				<div class="col-lg-6 mt-4">
					<a href="<?= base_url() ?>" class="btn btn-secondary form-control"><?= lang('Upload.cancel') ?></a>
				</div>
			</div>

		</div>
	</div>
</form>