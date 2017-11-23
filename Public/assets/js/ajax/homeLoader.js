(function($){


	$("li#pager").click(function(e){

		e.preventDefault()

		$.ajax({

			url: "/require-files/home/load.php?lastID=" + $(".article:last").attr("id"),

			beforeSend : function(){ 

				$('ul#getMore li a').remove()
				$("ul#getMore li").append('<a><span class="ng-loader ng-loader-quart"></a>') 


			},
			
			success: function(html)
			{
				if(html)
				{
					$("div#articles").append(html)

					$("ul#getMore li a").remove()
					$('ul#getMore li ').append('<a href="#">charger la suite</a>')

				}else{ 

					$("ul#getMore li a").remove()
					$('ul#getMore li').append('aucun contenu à charger')
				}
			}
		})
	})


})(jQuery)