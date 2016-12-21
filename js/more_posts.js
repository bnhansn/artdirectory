// TODO Clean up Code

var data = {'main_term' : null,
        'second_term' : null, "offset" : 0, "search_term" : 0, "modal_open": null, "mobile": false};

var main_query = function main_query(main_term_cat, second_term_cat, offset){
                        console.log(main_term_cat, second_term_cat);
                        if(data["main_term"]){
                          // Remove an adjusted class for the highlight functionality
                          // console.log("Removed", "." + data["main_term"].split(" ").join("_").replace("&",""));
                          // Build the class name to remove
                          // main_class_remove = "." + data["main_term"].split(" ").join("_").replace("&","")
                          jQuery('.main_field').removeClass("active_main")
                        }
                        if(data["second_term"]){
                          // Remove prior adjusted class to highlight a new item
                          // Build the class name to remove
                          second_class_remove = "." + data["second_term"].split(" ").join("_").replace("&","")
                          jQuery(second_class_remove).removeClass("active_sub")
                        }
                        data["main_term"] = main_term_cat
			data["second_term"] = second_term_cat
                        if(main_term_cat){
                          // Add an adjusted class for the highlight functionality
                          // Build the class name to add
                          main_class_add = "." + main_term_cat.split(" ").join("_").replace("&","")
                          jQuery(main_class_add).addClass("active_main")
                        }
                        if(second_term_cat){
                          // Add an adjusted class for the highlight functionality
                          // Build the class name to remove
                          second_class_add = "." + second_term_cat.split(" ").join("_").replace("&","")
                          jQuery(second_class_add).addClass("active_sub")
                        }
	if(!data['mobile']){
		loading()
	}
	data['search_term'] = "CATEGORIES"
	main_query = jQuery.ajax({
		url: more_posts.ajaxurl,
		type: "post",
		data: {
			action: "more_posts",
			main_term: main_term_cat,
			second_term: second_term_cat,
			offset: offset,
		},
		dataType: "html",
		success: function(response){
                        data["main_term"] = main_term_cat
			data["second_term"] = second_term_cat
			data['search_term'] = "CATEGORIES"
			display_artist(response, data['mobile'])
			return check_if_response(response)
		}
	});
}

search = function search(search_title, offset){
	loading();
	search_query = jQuery.ajax({
		url: more_posts.ajaxurl,
		type: "post",
		data: {
			action: "more_posts",
			search_term: search_title,
			offset: offset,
		},
		dataType: "html",
		success: function(response){
			data["search_term"] = search_title
			data["main_term"] = "SEARCH"
			display_artist(response, data['mobile'])
			return check_if_response(response)
		}
});
}

alphabet = function alphabet(alphabet){
	loading();
	alphabet_query = jQuery.ajax({
		url: more_posts.ajaxurl,
		type: "post",
		data: {
			action: "more_posts",
			alpha: alphabet,
			offset: offset,
		},
		dataType: "html",
		success: function(response){
			data["search_term"] = alphabet
			data["main_term"] = "SEARCH"
			display_artist(response)
			return check_if_response(response)
		}
});
}





function get_pagination_offset(){
	data["offset"]  = 0
	offset = data["offset"]

	// Handle Pagination Backwards
	jQuery('.back-page').click(function(){
		offset = data["offset"]
		if(offset != 0){
			offset = offset - 8;
			pagination_query(offset)
			data["offset"] = offset
			clean_up_pagination_ui();
		}else{
			console.log("This should never be seen")
		}
	});

	// Handle Pagination Forward
	jQuery('.forward-page').click(function(){
		offset = data['offset'];
		offset = offset + 8;
		pagination_query(offset)
		data["offset"] = offset
		clean_up_pagination_ui();
	});
}


/* These are helper functions */

function modal_build(artist){
		data["modal_open"] = artist;
		artist_data = data[artist]
		jQuery('.artist-first_name').html(artist_data['first_name'])
		jQuery('.artist-last_name').html(artist_data['last_name'])
		jQuery('.artist-web').html("<a href='http://" + artist_data['website'] + "'>" + artist_data['website'] + "</a>")
		jQuery('.artist-email').html("<a href='mailto:" + artist_data['email_address'] + "'>" + artist_data['email_address'] + "</a>")
		jQuery('.artist-phone').html(artist_data['phone_number'])
		jQuery('.artist-statement').html(artist_data['artists_statement']);
                jQuery('.artist-additional-header').html(artist_data['additional_information_header']);
                jQuery('.artist-additional').html(artist_data['additional_information']);
		jQuery('.artist-building').html(artist_data['building'])
		jQuery('.artist-street').html(artist_data['street'])
		jQuery('.artist-city').html(artist_data['city'])
		jQuery('.artist-state').html(artist_data['state'])
		jQuery('.artist-zip').html(artist_data['zip'])
		jQuery('.category-modal').html(artist_data['category'])
		if(artist_data['thumb_nail_image']){
					jQuery('.art-gal-itself').html(build_gallery(artist));
					slide_show()
		} else{
			jQuery('.art-gal-itself').html("No Gallery Available");
		}

    // TODO put this social media code in a helper function
    social_media = ""
		if(artist_data['facebook']){
				facebook_img = "<a href='http://" + artist_data['facebook'] + "'>"
			  facebook_img += "<img class='icon-next' src='/wp-content/plugins/artdirectory/assets/Facebook_purple_circle.png'/>"
				facebook_img += "</a>"
        social_media += facebook_img
		}

		if(artist_data['instagram']){
				instagram_img = "<a href='http://" + artist_data['instagram'] + "'>"
			  instagram_img += "<img class='icon-next' src='/wp-content/plugins/artdirectory/assets/Instagram_purple_circle.png'/>"
				instagram_img += "</a>"
        social_media += instagram_img
		}
    if(artist_data['twitter']){
        twitter_img = "<a href='http://" + artist_data['twitter'] + "'>"
        twitter_img += "<img class='icon-next' src='/wp-content/plugins/artdirectory/assets/twitter_purple_circle.png'/>"
        twitter_img += "</a>"
        social_media += twitter_img
    }
    jQuery('.social-icons').html(social_media)
		if(artist_data['map_field']){
			jQuery('.map_contains').replaceWith("<div class='map_contains'></div>")
			map_field = artist_data['map_field']
			jQuery('.map_contains').show()
			marker = ""
			marker += "<div class='marker' data-lat='"  + map_field.lat + "' data-lng='" + map_field.lng + "'>"
			marker += "</div>"
			jQuery('.map_contains').html(marker)
			setTimeout(function() { map_create(); }, 3000);
		}else{
			jQuery('.map_contains').hide()

		}
}


// This handles the slide show aspect of the modal
function slide_show(){
	jQuery('.art-gal-itself .gallery-item').first().toggleClass("active-gal")
	jQuery('.left').click(function(){
		index = jQuery( ".art-gal-itself .gallery-item" ).index( jQuery('.active-gal') );
		if(index > 0){
			jQuery('.active-gal').toggleClass("active-gal")
			jQuery(jQuery( ".art-gal-itself .gallery-item" )[index - 1]).toggleClass("active-gal")
		}
		gal_ui_clean()
	});
	jQuery('.right').click(function(){
		index = jQuery( ".art-gal-itself .gallery-item" ).index( jQuery('.active-gal') );
		if(jQuery( ".art-gal-itself .gallery-item" )[index+1]){
			jQuery('.active-gal').toggleClass("active-gal")
			jQuery(jQuery( ".art-gal-itself .gallery-item" )[index + 1]).toggleClass("active-gal")
		}
		gal_ui_clean()
	});
	gal_ui_clean()
}

function gal_ui_clean(){
	index = jQuery( ".art-gal-itself .gallery-item" ).index( jQuery('.active-gal') );
	if(index === 0){
		jQuery('.left').hide()
	}else {
		jQuery('.left').show()
	}
	if(jQuery(jQuery( ".art-gal-itself .gallery-item" )[index+1]).length){
		jQuery('.right').show()
	}else{
		jQuery('.right').hide()
	}
}






function build_gallery(artist){
	return data[artist+"gallery"]
}

function display_artist(response){
	cleaned_response = jQuery.parseJSON(response);
	// cleaned_response = response.replace(/[\]\[\"]+/g, '').split(",");
	artist_posts = ""
	cleaned_response.forEach(function(artist){
		artist_posts += build_artist(artist)
	});
	if (data['mobile']){
		jQuery('.artists').append(artist_posts);
	} else{
		jQuery('.artists').html(artist_posts);
	}
}

function build_artist(artist){
	data[artist[0]] = artist[1]
	data[artist[0]+"gallery"] = artist[2]
	build_artist_str = ""
	build_artist_str += "<div class='col-md-3 artist_post'><a data-toggle='modal' data-target='#artist' onclick='modal_build("+ "&quot;" + artist[0] + "&quot;" + ")'>"
	if(artist[1]['thumb_nail_image'] && artist[1]['thumb_nail_image']['sizes']['medium']){
		build_artist_str += "<img src='" + artist[1]['thumb_nail_image']['sizes']['medium'] + "'/>"
	}
	if(!artist[1]['category']){
		artist[1]['category'] = "No Category Available"
	}
	build_artist_str += "<div class='artist-thu-title'>" + artist[0] + "<div class= "+ "'" + "category-post" + " ' >" + artist[1]['category'] + "</div></div></a></div>";
	build_artist_str += ""
	return build_artist_str
}

function clean_up_pagination_ui(data_length){
	offset = data["offset"];
	if(offset === 0){
		jQuery('.back-page').hide()
	}else if (offset >= 8 && !data['mobile']) {
		jQuery('.back-page').show()
	}
	if(data_length < 8){
		jQuery('.forward-page').hide()
	} else if(data['mobile']){
		jQuery('.forward-page').hide()
	}
	else{
		jQuery('.forward-page').show()
	}
}


function pagination_query(offset){
	query_categories_main = data["main_term"];
	query_categories_second = data["second_term"]
	query_search = data["search_term"];
	if(query_search === "CATEGORIES"){
		if(query_categories_main && query_categories_second){
			return main_query(query_categories_main, query_categories_second, offset)
		}else if(query_categories_main){
                        return main_query(query_categories_main, null, offset)
                }else{
			return main_query(null, null, offset)
		}
	}else{
		if(query_search){
			return search(query_search, offset)
		}
	}
}

function check_if_response(response){
	data_length = jQuery.parseJSON(response).length
	clean_up_pagination_ui(data_length)
	if(data_length){
		return true
	}else{
		return false
	}
}

function loading(){
	loading_gif = "<img src='/wp-content/plugins/artdirectory/js/loading_spinner.gif' class='loader' />"
	jQuery('.artists').html(loading_gif);
}

jQuery("#slider").slider({
  min: 55,
  max: 90,
  slide: function( event, ui ) {
		if(ui.value > 64){
	    jQuery('#display').text(String.fromCharCode(ui.value));
		} else {
			digits = [55, 56, 57, 58, 59, 60, 61, 62, 63, 64]
			jQuery('#display').text(digits.indexOf(ui.value).toString())
		}
  },
    change: function (event, ui) {
	if(ui.value > 64){
    jQuery('#display').text(String.fromCharCode(ui.value));
		alphabet(String.fromCharCode(ui.value))
	} else {
		digits = [55, 56, 57, 58, 59, 60, 61, 62, 63, 64]
		jQuery('#display').text(digits.indexOf(ui.value).toString())

		alphabet(digits.indexOf(ui.value).toString())
	}
    }
});


if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEmobile|Opera Mini/i.test(navigator.userAgent) ) {
	data['mobile'] = true
	jQuery(window).scroll(function () {
     if (jQuery(window).scrollTop() >= jQuery(document).height() - jQuery(window).height() - 10) {
			 	data["offset"] += 8
			 	offset = data["offset"];
        pagination_query(offset)
     }
  });
}
