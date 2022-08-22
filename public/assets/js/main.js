/*!
	* WarhammerRosters
	* Copyright (C) 2022 Santiago González Lago

	* This program is free software: you can redistribute it and/or modify
	* it under the terms of the GNU General Public License as published by
	* the Free Software Foundation, either version 3 of the License, or
	* (at your option) any later version.

	* This program is distributed in the hope that it will be useful,
	* but WITHOUT ANY WARRANTY; without even the implied warranty of
	* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	* GNU General Public License for more details.

	* You should have received a copy of the GNU General Public License
	* along with this program.  If not, see <https://www.gnu.org/licenses/>.
	*/

$(function() {
	$('.dropdown-menu form').click(function(e) {
		e.stopPropagation();
	});

	$('#login-form').on('submit', function(e) {
		e.preventDefault();
		$('#login-error').hide();
		$('#login-error').html('');

		$.ajax({
			type: 'post',
			url: BASE_URL + '/auth/login',
			dataType: 'json',
			data: {
				email: $('#login-email').val(),
				password: $('#login-password').val(),
			},
			success: function (data) {
				if (data.success) {
					location.reload();
				} else {
					$('#login-error').show();
					$('#login-error').html(data.error);  
				}
			}
		});
	});

});