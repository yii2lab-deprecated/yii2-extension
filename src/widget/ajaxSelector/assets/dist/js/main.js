
(function($){
	
	var setOptions = function (config, data) {
		var elementId = '#'+config.item.child.elementId;
		var selector = $(elementId);
		var selector_options = selector.find('option');
		var primaryKey = config.item.child.primaryKey;
		selector_options.remove();
		selector.prop('disabled', empty(data));
		data.unshift({
			name: config.item.child.prompt,
			id: 0,
		});
		for(var index in data) {
		    var item = data[index];
		    selector.append( $('<option value="'+item[primaryKey]+'">'+item.name+'</option>'));
		    selector.change();
		}
	};
	
	var runRequest = function (config, data) {
		if(empty(config.item.child)) {
			return;
		}
		data['per-page'] = 9999999;
		var successHandler = function (data) {
			setOptions(config, data);
		};
        var host = trim(app.env.url.api, '/');
        var request = {
            url: host + '/' + config.item.child.uri,
            data: data,
        };
        $.domain.rest.request.send(request, successHandler);
	};
	
	var attachHandler = function (config) {
		var element = $('#'+config.item.elementId);
		if(empty(element)) {
			return;
		}
		var changeHandler = function(){
			var value = element.val();
			if(!empty(value)) {
				var key = config.item.elementName;
				var data = {};
				data[key] = value;
				runRequest(config, data);
			} else {
				setOptions(config, []);
			}
		};
		element.change(changeHandler);
	};
	
	$.ajaxSelector = {
		loadAll: function (config) {
			for(var index in config) {
				attachHandler({
					item: config[index]
				});
			}
		},
	};
	
})(jQuery);
