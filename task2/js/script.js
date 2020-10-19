document.addEventListener('DOMContentLoaded', function () {
	const form = document.getElementById('form_js');

	form.addEventListener('submit', formSend);

	async function formSend(e) {
		e.preventDefault();
		let formData = new FormData(form);
		let date = new Date();
		formData.append('client_hours', date.getHours());
		formData.append('client_day', date.getDay());

		form.classList.add('_sendForm');
		let response = await fetch('index.php', {
			method: 'POST',
			body: formData
		});

		let columns_to_remove = document.getElementsByClassName('table__column_inst');
		for (let i = columns_to_remove.length-1; i >= 0; i--) {
			columns_to_remove[i].remove();
		}
		
		if (response.ok) {
			let result = await response.json();
			
			if (typeof result.error !== 'undefined') {
				alert(result.error);
				form.classList.remove('_sendForm');
				return false;
			}

			document.getElementById('tax_persent_span_js').textContent = '(' + result.tax_persent + '%)';
			document.getElementById('base_premium_span_js').textContent = '(' + result.policy.basePricePersent + '%)';

			let total_policy = result.policy.totalPolicy;
			
			let ploicy_value = document.getElementById('ploicy_value_js');
			ploicy_value.textContent = result.value.toFixed(2);
			
			for (let ploicy_entity in total_policy ) {
				let ploicy_cell = document.getElementById('ploicy_' + ploicy_entity + '_js');
				ploicy_cell.textContent = total_policy[ploicy_entity].toFixed(2);
			}

			for (let i = 0; i < result.policy.instalmentList.length; i++) {
				createRow(result.policy.instalmentList[i], i);
			}
			
		} else {

		}
		form.classList.remove('_sendForm');
	}

	function createRow(policy, j)
	{
		let div_column = document.createElement("div");
		div_column.classList.add('table__column', 'table__column_inst');
		
		let div_item = document.createElement("div");
		div_item.classList.add('table__item', 'table__item_inst');
		
		let div_header_cell = document.createElement("div");
		div_header_cell.classList.add('table__cell', 'table__header');
		div_header_cell.textContent = (j+1) + ' instalment';
		div_item.appendChild(div_header_cell);

		let empty_div = document.createElement("div");
		empty_div.classList.add('table__cell');
		div_item.appendChild(empty_div);

		for (let ploicy_entity in policy ) {
			let div_cell = document.createElement("div");
			div_cell.classList.add('table__cell');
			div_cell.textContent = policy[ploicy_entity].toFixed(2);
			div_item.appendChild(div_cell);
		}

		div_column.appendChild(div_item);

		let table_row = document.getElementById('table_row_js');
		table_row.appendChild(div_column);
	}
});