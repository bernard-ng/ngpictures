(function($){


	$("ul#getMore li").onclick(function(e){

		e.preventDefault()

		$.ajax({


			url: "/require-files/profil/load.php?lastID=" + $("#articles .article:last").attr('id') +"&userID="+ $("div.userID").attr('id'),

			beforeSend : function(){

				$("ul#getMore li#pager").remove()
				$("ul#getMore li#pager").append('<a><span class="loader ng-loader-quart"></span></a>')

			},

			success: function(html){

				if(html){

					$('#articles').append(html)

					$("ul#getMore li#pager").remove()
					$("ul#getMore li#pager").append('<a>Charger la suite</a>')

				}else{

					$("ul#getMore li#pager").remove()
					$("ul#getMore li#pager").append('<a>Charger la suite</a>')
				}

			}

		})
	})

})(jQuery)