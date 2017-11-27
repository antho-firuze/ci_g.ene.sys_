<script>
  var options = {
    allow_empty: true,

    // default_filter: 'name',
    sort_filters: true,

    optgroups: {
      core: {
        en: 'Core',
        fr: 'Coeur'
      }
    },

    plugins: {
      'bt-tooltip-errors': { delay: 100 },
      'sortable': null,
      'filter-description': { mode: 'bootbox' },
      'bt-selectpicker': null,
      'unique-filter': null,
      'bt-checkbox': { color: 'primary' },
      'invert': null,
      'not-group': null
    },

    // standard operators in custom optgroups 
    operators: [
      { type: 'equal', optgroup: 'basic' },
      { type: 'not_equal', optgroup: 'basic' },
      { type: 'in', optgroup: 'basic' },
      { type: 'not_in', optgroup: 'basic' },
      { type: 'less', optgroup: 'numbers' },
      { type: 'less_or_equal', optgroup: 'numbers' },
      { type: 'greater', optgroup: 'numbers' },
      { type: 'greater_or_equal', optgroup: 'numbers' },
      { type: 'between', optgroup: 'numbers' },
      { type: 'not_between', optgroup: 'numbers' },
      { type: 'begins_with', optgroup: 'strings' },
      { type: 'not_begins_with', optgroup: 'strings' },
      { type: 'contains', optgroup: 'strings' },
      { type: 'not_contains', optgroup: 'strings' },
      { type: 'ends_with', optgroup: 'strings' },
      { type: 'not_ends_with', optgroup: 'strings' },
      { type: 'is_empty' },
      { type: 'is_not_empty' },
      { type: 'is_null' },
      { type: 'is_not_null' }
    ],
	};
	
	var Filter_Fields = [
		/*
		 * string with separator
		 */
		{
			id: 'name',
			field: 'username',
			label: {
				en: 'Name',
				fr: 'Nom'
			},
			value_separator: ',',
			type: 'string',
			optgroup: 'core',
			default_value: 'Mistic',
			size: 30,
			validation: {
				allow_empty_value: true
			},
			unique: true
		},
		/*
		 * integer with separator for 'in' and 'not_in'
		 */
		{
			id: 'age',
			label: 'Age',
			type: 'integer',
			input: 'text',
			value_separator: '|',
			optgroup: 'core',
			description: function(rule) {
				if (rule.operator && ['in', 'not_in'].indexOf(rule.operator.type) !== -1) {
					return 'Use a pipe (|) to separate multiple values with "in" and "not in" operators';
				}
			}
		},
		/*
		 * textarea
		 */
		{
			id: 'bson',
			label: 'BSON',
			type: 'string',
			input: 'textarea',
			operators: ['equal'],
			size: 30,
			rows: 3
		},
		/*
		 * checkbox
		 */
		{
			id: 'category',
			label: 'Category',
			type: 'integer',
			input: 'checkbox',
			optgroup: 'core',
			values: {
				1: 'Books',
				2: 'Movies',
				3: 'Music',
				4: 'Tools',
				5: 'Goodies',
				6: 'Clothes'
			},
			colors: {
				1: 'foo',
				2: 'warning',
				5: 'success'
			},
			operators: ['equal', 'not_equal', 'in', 'not_in', 'is_null', 'is_not_null'],
			default_operator: 'in'
		},
		/*
		 * select
		 */
		{
			id: 'continent',
			label: 'Continent',
			type: 'string',
			input: 'select',
			optgroup: 'core',
			placeholder: 'Select something',
			values: {
				'eur': 'Europe',
				'asia': 'Asia',
				'oce': 'Oceania',
				'afr': 'Africa',
				'na': 'North America',
				'sa': 'South America'
			},
			operators: ['equal', 'not_equal', 'is_null', 'is_not_null']
		},
		/*
		 * Selectize
		 */
		{
			id: 'state',
			label: 'State',
			type: 'string',
			input: 'select',
			multiple: true,
			plugin: 'selectize',
			plugin_config: {
				valueField: 'id',
				labelField: 'name',
				searchField: 'name',
				sortField: 'name',
				options: [
					{ id: "AL", name: "Alabama" },
					{ id: "AK", name: "Alaska" },
					{ id: "AZ", name: "Arizona" },
					{ id: "AR", name: "Arkansas" },
					{ id: "CA", name: "California" },
					{ id: "CO", name: "Colorado" },
					{ id: "CT", name: "Connecticut" },
					{ id: "DE", name: "Delaware" },
					{ id: "DC", name: "District of Columbia" },
					{ id: "FL", name: "Florida" },
					{ id: "GA", name: "Georgia" },
					{ id: "HI", name: "Hawaii" },
					{ id: "ID", name: "Idaho" }
				]
			},
			valueSetter: function(rule, value) {
				rule.$el.find('.rule-value-container select')[0].selectize.setValue(value);
			}
		},
		/*
		 * radio
		 */
		{
			id: 'in_stock',
			label: 'In stock',
			type: 'integer',
			input: 'radio',
			optgroup: 'plugin',
			values: {
				1: 'Yes',
				0: 'No'
			},
			operators: ['equal']
		},
		/*
		 * double
		 */
		{
			id: 'price',
			label: 'Price',
			type: 'double',
			size: 5,
			validation: {
				min: 0,
				step: 0.01
			},
			data: {
				class: 'com.example.PriceTag'
			}
		},
		/*
		 * slider
		 */
		{
			id: 'rate',
			label: 'Rate',
			type: 'integer',
			validation: {
				min: 0,
				max: 100
			},
			plugin: 'slider',
			plugin_config: {
				min: 0,
				max: 100,
				value: 0
			},
			onAfterSetValue: function(rule, value) {
				var input = rule.$el.find('.rule-value-container input');
				input.slider('setValue', value);
				input.val(value); // don't know why I need it
			}
		},
		/*
		 * placeholder and regex validation
		 */
		{
			id: 'id',
			label: 'Identifier',
			type: 'string',
			optgroup: 'plugin',
			placeholder: '____-____-____',
			size: 14,
			operators: ['equal', 'not_equal'],
			validation: {
				format: /^.{4}-.{4}-.{4}$/,
				messages: {
					format: 'Invalid format, expected: AAAA-AAAA-AAAA'
				}
			}
		},
		/*
		 * custom input
		 */
		{
			id: 'coord',
			label: 'Coordinates',
			type: 'string',
			default_value: 'C.5',
			description: 'The letter is the cadran identifier:\
<ul>\
<li><b>A</b>: alpha</li>\
<li><b>B</b>: beta</li>\
<li><b>C</b>: gamma</li>\
</ul>',
			validation: {
				format: /^[A-C]{1}.[1-6]{1}$/
			},
			input: function(rule, name) {
				var $container = rule.$el.find('.rule-value-container');

				$container.on('change', '[name=' + name + '_1]', function() {
					var h = '';

					switch ($(this).val()) {
						case 'A':
							h = '<option value="-1">-</option> <option value="1">1</option> <option value="2">2</option>';
							break;
						case 'B':
							h = '<option value="-1">-</option> <option value="3">3</option> <option value="4">4</option>';
							break;
						case 'C':
							h = '<option value="-1">-</option> <option value="5">5</option> <option value="6">6</option>';
							break;
					}

					$container.find('[name$=_2]')
						.html(h).toggle(!!h)
						.val('-1').trigger('change');
				});

				return '\
<select name="' + name + '_1"> \
<option value="-1">-</option> \
<option value="A">A</option> \
<option value="B">B</option> \
<option value="C">C</option> \
</select> \
<select name="' + name + '_2" style="display:none;"></select>';
			},
			valueGetter: function(rule) {
				return rule.$el.find('.rule-value-container [name$=_1]').val()
					+ '.' + rule.$el.find('.rule-value-container [name$=_2]').val();
			},
			valueSetter: function(rule, value) {
				if (rule.operator.nb_inputs > 0) {
					var val = value.split('.');

					rule.$el.find('.rule-value-container [name$=_1]').val(val[0]).trigger('change');
					rule.$el.find('.rule-value-container [name$=_2]').val(val[1]).trigger('change');
				}
			}
		},
		{
			// Boolean 
			unique: true,
			id: 'is_import',
			label: 'Is Import',
			type: 'string',
			input: 'radio',
			values: {	'1': 'Yes',	'0': 'No'	},
			operators: ['equal'],
		},{
			// Numeric 
			unique: true,
			id: 'grand_total',
			label: 'Grand Total',
			type: 'double',
			size: 5,
			validation: {	min: 0,	step: 0.01 },
		},{
			// Datetime 
			unique: true,
			id: 't1.doc_date',
			label: 'Doc Date',
			type: 'datetime',
			plugin: 'datepicker',
			plugin_config: { format: "yyyy-mm-dd", todayBtn: 'linked', todayHighlight: true, autoclose: true },
			input_event: 'dp.change',
			description: 'Format date yyyy-mm-dd. Ex: 2017-11-22',
		},
	];
	
</script>
