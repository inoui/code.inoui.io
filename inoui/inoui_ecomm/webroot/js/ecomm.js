Inoui.define('Inoui.Ecomm', Inoui.extend({
    init:function() {
      
    },
    ready:function() {
    	$(".fancybox").fancybox({
    	  oncomplete:function() {
			$('.fancybox-inner').jqzoom({
				zoomType: 'innerzoom',
                title: false,
				lens: false,
				showEffect: 'fadein',
				hideEffect: 'fadeout',

			});
    	  },
  helpers: {
    overlay: {
      locked: false
    }
  }

    	});
}

  })
);
