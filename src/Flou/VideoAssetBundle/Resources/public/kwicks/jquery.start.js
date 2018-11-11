$().ready(function() {
		var width = $('.widget1').width();
		var elements = $('.widget1 .horiplaylistwidget_li');
		elements.css({ 'width': (width-0)/elements.length});
		
		width = width*2/3;
		width = Math.min(width,640);
		
		if(elements.length>1){
		$('.widget1 .horiplaylistwidget_ul').kwicks({
			max : width,
			spacing : 0
		});}
		
		width = $('.widget2').width();
		elements = $('.widget2 .horiplaylistwidget_li');
		elements.css({ 'width': (width-0)/elements.length});
		
		width = width*2/3;
		width = Math.min(width,640);
		
		if(elements.length>1){
		$('.widget2 .horiplaylistwidget_ul').kwicks({
			max : width,
			spacing : 0
		});}
		
		width = $('.widget3').width();
		elements = $('.widget3 .horiplaylistwidget_li');
		elements.css({ 'width': (width-0)/elements.length});
		
		width = width*2/3;
		width = Math.min(width,640);
		
		if(elements.length>1){
		$('.widget3 .horiplaylistwidget_ul').kwicks({
			max : width,
			spacing : 0
		});}
		
		width = $('.widget4').width();
		elements = $('.widget4 .horiplaylistwidget_li');
		elements.css({ 'width': (width-0)/elements.length});
		
		width = width*2/3;
		width = Math.min(width,640);
		
		if(elements.length>1){
		$('.widget4 .horiplaylistwidget_ul').kwicks({
			max : width,
			spacing : 0
		});}
	});