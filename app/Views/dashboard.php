<?php
// WarhammerRosters
// Copyright (C) 2022 Santiago González Lago

// This program is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.

// This program is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.

// You should have received a copy of the GNU General Public License
// along with this program.  If not, see <https://www.gnu.org/licenses/>.
?>

<div class="row">
	<div class="col-lg-3">
		<div class="mb-3">
			<label for="title" class="form-label"><?= lang('Dashboard.title') ?></label>
			<input type="text" id="title" class="filter form-control">
		</div>
		<div class="mb-3">
			<label for="battle-size" class="form-label"><?= lang('Dashboard.battle_size') ?></label>
			<select id="battle-size" class="filter selectpicker form-control" multiple data-selected-text-format="count" data-actions-box="true" data-select-all-text="<?= lang('Dashboard.select_all') ?>" data-deselect-all-text="<?= lang('Dashboard.deselect_all') ?>" data-count-selected-text="<?= lang('Dashboard.count_selected') ?>" data-live-search="true" title="<?= lang('Dashboard.nothing_selected') ?>">
				<?php foreach ($battleSizes as $option) : ?>
					<option value="<?= $option->id ?>" data-subtext="(<?= $option->total ?>)" <?= $option->total > 0 ? '' : "disabled" ?>><?= $option->name ?></option>
				<?php endforeach; ?>
			</select>
		</div>
		<div class="mb-3">
			<label for="game-type" class="form-label"><?= lang('Dashboard.game_type') ?></label>
			<select id="game-type" class="filter selectpicker form-control" multiple data-selected-text-format="count" data-actions-box="true" data-select-all-text="<?= lang('Dashboard.select_all') ?>" data-deselect-all-text="<?= lang('Dashboard.deselect_all') ?>" data-count-selected-text="<?= lang('Dashboard.count_selected') ?>" data-live-search="true" title="<?= lang('Dashboard.nothing_selected') ?>">
				<?php foreach ($gameTypes as $option) : ?>
					<option value="<?= $option->id ?>" data-subtext="(<?= $option->total ?>)" <?= $option->total > 0 ? '' : "disabled" ?>><?= $option->name ?></option>
				<?php endforeach; ?>
			</select>
		</div>
		<div class="mb-3">
			<label for="armies" class="form-label"><?= lang('Dashboard.armies') ?></label>
			<select id="armies" class="filter selectpicker form-control" multiple data-selected-text-format="count" data-actions-box="true" data-select-all-text="<?= lang('Dashboard.select_all') ?>" data-deselect-all-text="<?= lang('Dashboard.deselect_all') ?>" data-count-selected-text="<?= lang('Dashboard.count_selected') ?>" data-live-search="true" title="<?= lang('Dashboard.nothing_selected') ?>">
				<?php foreach ($armies as $option) : ?>
					<option value="<?= $option->id ?>" data-subtext="(<?= $option->total ?>)" <?= $option->total > 0 ? '' : "disabled" ?>><?= $option->name ?></option>
				<?php endforeach; ?>
			</select>
		</div>
		<div class="mb-3">
			<label for="user" class="form-label"><?= lang('Dashboard.creator') ?></label>
			<select id="user" class="filter selectpicker form-control" multiple data-selected-text-format="count" data-actions-box="true" data-select-all-text="<?= lang('Dashboard.select_all') ?>" data-deselect-all-text="<?= lang('Dashboard.deselect_all') ?>" data-count-selected-text="<?= lang('Dashboard.count_selected') ?>" data-live-search="true" title="<?= lang('Dashboard.nothing_selected') ?>">
				<?php foreach ($users as $option) : ?>
					<option value="<?= $option->id ?>" data-subtext="(<?= $option->total ?>)" <?= $option->total > 0 ? '' : "disabled" ?>><?= $option->name ?></option>
				<?php endforeach; ?>
			</select>
		</div>
	</div>
	<div class="col-lg-9">
		<div class="table-responsive pb-3">
			<table id="roster-table" class="table table-striped">
				<thead>
					<tr>
						<th><?= lang('Dashboard.title') ?></th>
						<th><?= lang('Dashboard.file') ?></th>
						<th><?= lang('Dashboard.battle_size') ?></th>
						<th><?= lang('Dashboard.game_type') ?></th>
						<th><?= lang('Dashboard.armies') ?></th>
						<th><?= lang('Dashboard.creator') ?></th>
						<th><?= lang('Dashboard.last_update') ?></th>
					</tr>
				</thead>
			</table>
		</div>
	</div>
</div>


<script>
	$(function() {
		let rosterTable = $('#roster-table').DataTable({
			processing: true,
			serverSide: true,
			ajax: {
				url: '<?= base_url('dashboard/datatable') ?>',
				data: function (d) {
					d.title =      $('#title').val();
					d.battleSize = $('#battle-size').val();
					d.gameType =   $('#game-type').val();
					d.armies =     $('#armies').val();
					d.user =       $('#user').val();
				}
			},
			language: {
				lengthMenu:   '<?= lang('Dashboard.dt_lengthMenu') ?>',
				zeroRecords:  '<?= lang('Dashboard.dt_zeroRecords') ?>',
				info:         '<?= lang('Dashboard.dt_info') ?>',
				infoEmpty:    '<?= lang('Dashboard.dt_infoEmpty') ?>',
				infoFiltered: '<?= lang('Dashboard.dt_infoFiltered') ?>',
				paginate: {
					first:    '<?= lang('Dashboard.dt_paginate_first') ?>',
					last:     '<?= lang('Dashboard.dt_paginate_last') ?>',
					next:     '<?= lang('Dashboard.dt_paginate_next') ?>',
					previous: '<?= lang('Dashboard.dt_paginate_previous') ?>'
				},
			},
			bFilter: false,
			order: [[6, 'desc']],
		});

		$('.filter').change(function(event) {
			rosterTable.ajax.reload();
		});

	});
</script>