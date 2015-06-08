if(jQuery){
    (function($,window){
        $(function () {
            $('.post_content').on('click',function () {
                var $href = $(this).find('.post-title').attr('href');
                window.location.href = $href;
            });

            if($('body').hasClass('single')){
            	var $current_post = $('.post .entry-content');


            	var $headers = $current_post.find(':header');

            	if(!$headers.length){
            		return;
            	}
            	// $headers.addClass(function () {
            	// 	return 'post-nav-' + this.tagName.toLowerCase();
            	// });

            	$current_post.css('position','relative');
            	$post_nav_widget = $("<div class='post-nav-widget'></div>");

            	$headers.each(function (i,v) {
            		var id = 'header-id-' + i;
            		$(v).attr({
            			'id':id,
            			'class': 'post-nav-' + v.tagName.toLowerCase()
            		});


            		$link = $('<a />').attr({
            			'class': "link-nav-"+v.tagName.toLowerCase(),
            			'href' : '#' + id
            		}).text(v.innerText)

            		$post_nav_widget.append($link);

            	});

            	$current_post.append($post_nav_widget);

            	if($(window).width() < 490){
            		return;
            	}

            	$(window).scroll(function() {
            	    clearTimeout($.data(this, 'scrollTimer'));
            	    $.data(this, 'scrollTimer', setTimeout(function() {

            	    	// console.log('post top : ' + $current_post.offset().top);
            	    	// console.log('doc scroll top: ' + $(document).scrollTop());
            	    	scrolltop = $(document).scrollTop() - $current_post.offset().top + 120;
            	    	if(scrolltop < 0){
            	    		scrolltop = 0;
            	    	}
            	       $post_nav_widget.css('top', scrolltop + "px");
            	    }, 500));
            	});


            }


            var TemplateEngine = function(html, options) {
                var re = /<%([^%>]+)?%>/g, reExp = /(^( )?(if|for|else|switch|case|break|{|}))(.*)?/g, code = 'var r=[];\n', cursor = 0, match;
                var add = function(line, js) {
                    js? (code += line.match(reExp) ? line + '\n' : 'r.push(' + line + ');\n') :
                        (code += line != '' ? 'r.push("' + line.replace(/"/g, '\\"') + '");\n' : '');
                    return add;
                }
                while(match = re.exec(html)) {
                    add(html.slice(cursor, match.index))(match[1], true);
                    cursor = match.index + match[0].length;
                }
                add(html.substr(cursor, html.length - cursor));
                code += 'return r.join("");';
                return new Function(code.replace(/[\r\t\n]/g, '')).apply(options);
            }


            if($('.buy-channel').length){
                load_book_info();
            }





            function load_book_info (keyword) {
                $.ajax({
                   url: '../load_book_info.php',
                   type: 'GET',
                   dataType: 'json',
                   data: {
                        keyword: '白夜行'
                    },
                })
                .done(function(data) {
                   if(data&&data.length){
                     // var str = '';
                     // for (var i = 0; i < data.length; i++) {
                     //     var a = data[i];
                     //     str += a.title + "<br />";
                     // };




                     var template = 
                        '<ul class="relate-book-list">'+
                        '<%for(var index in this.books) {%>' + 
                        '<li>'+
                         '<a href="<%this.books[index]["url"]%>"><%this.books[index]["title"]%></a>' +
                         '<img src="<%this.books[index]["img"]%>" />'+
                         '<%}%>'+
                         '</li>'+
                         '</ul>';
                     var str = TemplateEngine(template, {
                         books: data
                     });
                     $('.buy-channel').append(str);
                   }
                })
                .fail(function() {
                   console.log("error");
                })
                .always(function() {
                   console.log("complete");
                });

            }







        });

    })(jQuery,this);
}