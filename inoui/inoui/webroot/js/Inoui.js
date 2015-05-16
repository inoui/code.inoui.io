(function($,w) {

    "use strict",

    $.ajaxSetup({
        global: false,
        type: "POST",
        dataType:"json"
    });

	this.Inoui = {}; 
	this.Inoui._config = {}; 

	Inoui.Class = function(){};

	Inoui.pattern = (function() {
		return {
			isString: function(value) {
				return typeof value === 'string';
			},
			isArray: function(value) {
		       	return value.constructor == Array;
		    },
		    isFilemap: function(value) {
		    	if (this.isObject(value) && !this.isString(value)) {	
		    		for (var key in value) {
		    			if (!this.isString(key)) return false;
		    			if (!this.isArray(value[key])) return false;
		    		}
		    	} else {
		    		return false;
		    	}
		    	return true;
		    },
		    isNumber: function(value) {
		    	return Object.prototype.toString.call(value) === '[object Number]';
		    },
		    isObject: function(value) {
		    	return Object.prototype.toString.call(value) === '[object Object]';
		    },
		    isClass: function(value) {
		    	return (typeof(value) == "function" && typeof(value.prototype) == "object") ? true : false; 
		    },
		    isFunction: function(value) {
				return Object.prototype.toString.apply(value) === '[object Function]';
			},
			isBoolean: function(value) {
				return Object.prototype.toString.apply(value) === '[object Boolean]';
			},
			isURI: function(value) {
				var regex =  new RegExp('(ftp|http|https)','ig');
				return value.match(regex) ? true : false;
			}
		}
	})();
	
	Inoui.apply = function(object, config, defaults) {
        if (defaults) {
            Inoui.apply(object, defaults);
        }
        if (object && config && typeof config === 'object') {
            for (var i in config) {
                object[i] = config[i];
            }
        }        
        return object;
    };

    Inoui.url = function() {
        var s = arguments[0][0];
        var library = '';
        if (s instanceof Array) {
            library = s[0]+'/';
            s = s[1];
        }

        if (s.indexOf("::") != -1) {
            return conf.baseUrl+'/'+library+s.replace(/::/g, '/').toLowerCase();
        } else {
            return s;
        }
    }

    Inoui.call = function() {
        var action = Inoui.url(arguments),
            data = arguments[1],
            callback = (arguments.length>2)?arguments[2]:null;
            
        var opt = {
            url: action,
			      data: data,
            success:$.proxy(callback, this)
        };

        if (callback == null) opt.async = false;
        var options = $.extend(opt, Inoui._config.ajaxOptions, data);
//        if (options.data.dataType != undefined) options.data.dataType = undefined;

        if (callback == null) {
            return $.ajax(options).responseText;
        } else {
            $.ajax(options);
        }
    };

    Inoui.__do = function(evt) {

      evt && evt.preventDefault();
      var namespaces = String('Inoui.' + $(evt.currentTarget).data('action')).split('.');
      var method = namespaces.pop();
      var scope = window;
			for (var i = 0; i < namespaces.length; i++) {
				var namespace = namespaces[i];

				scope = scope[namespace];
			}

      scope[method](evt);
      
      
//      window['Inoui'][action[0]][action[1]](evt);
    };

    Inoui.__submit = function(evt) {

        evt && evt.preventDefault();
        var calback = $(evt.target).data('callback');

        var namespaces = String('Inoui.' + calback).split('.');
        var method = namespaces.pop();
        var scope = window;
        for (var i = 0; i < namespaces.length; i++) {
            var namespace = namespaces[i];
            scope = scope[namespace];
        }

        $(evt.target).ajaxSubmit({ 
            success: $.proxy(scope.method, scope), 
            dataType:'json' 
        });


      // scope[method](evt);
      
      
//      window['Inoui'][action[0]][action[1]](evt);
    };


    Inoui.__confirm = function(evt) {
      evt && evt.preventDefault() && evt.stopPropagation();

      var $elt = $(evt.currentTarget);
      var href    = $elt.attr('href');
      var action  = $elt.data('action');
      
      if (action != undefined) {
        if ($elt.data('confirm') == true) {
          $elt.data('confirm', false);
          return true;
        } else {
          evt.stopImmediatePropagation();
          $elt.data('confirm', false);
          $('#modal-confirm .btn.btn-danger').one('click', function() {
              $elt.data('confirm', true).trigger('click');
              $('#modal-confirm').modal('hide');
              return false;
          });
        }
      } else {
        $('#modal-confirm .btn.btn-danger').attr('href', href);
      }
      $('#modal-confirm').modal('show');
    };


    $('body')
        .on ('click', '.confirm', Inoui.__confirm)
        .on('click', '.action', Inoui.__do)
        .on('change', '.change', Inoui.__do)
        .on('submit', 'form[data-submit=ajax]', Inoui.__submit);


    Inoui.Class.prototype = {
      _config :{},
      _service   : Inoui.call,
	    _isIpad :(navigator.userAgent.match(/iPad/i) != null) ? true : false,
    };

    Inoui.apply(Inoui.Class, {
		  extend: function(object) {
			  Inoui.constructing = true;
			  var proto = new this(), 
			      superclass = this.prototype;
        delete Inoui.constructing;
			  Inoui.apply(proto, object);
			  var Class = proto.constructor = function()  {
				if (!Inoui.constructing && this.init) {
					this.init.apply(this, arguments);
				}
				if(this.ready) $(document).ready($.proxy(this.ready, this));
			};
			proto.superclass = superclass;
			Inoui.apply(Class, {
				prototype:   proto,
				constructor: Class,
				ancestor:    this,
				extend: 	 this.extend
			});
			
			return new Class;
		}
	});

  Inoui.apply(Inoui, {
    	namespace: (function() {
			return Inoui.apply(Inoui,{
				register: function(namespace, scope, object) {
					var namespaces = namespace.split('.');
					for (var i = 0; i < namespaces.length; i++) {
						var namespace = namespaces[i];
						if (!this.exists(namespace, scope)) {
							scope[namespace] = object;
						}
						scope = scope[namespace];
					}
					return scope;
				},
				exists: function(namespace, scope) {
					return (!scope || typeof scope[namespace] === "undefined") ? false : true;
				}
      })
		})(),
		define: function(namespace, object) {
			return this.namespace.register(namespace, window, object);
		},        
		extend: function(object) {
			return Inoui.Class.extend(object);
		}
		
});

})(jQuery, window);