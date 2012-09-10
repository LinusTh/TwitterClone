$(document).ready(function()
{
	//Default antal tweets som syns
	var tweetsShowing = 10;
	
	
	if($('#following').text() == 'Följer')
	{
		$('#followbutton').attr('value', 'Sluta följ');
	}
	else
	{
		$('#followbutton').attr('value', 'Följ');
	}
	
	
	//Knappen posta tweet ska vara disabled...
	$('#button').attr('disabled', true);
	
	//...tills man skriver något i rutan
	$('#tweetarea').keyup(function()
	{
		var text = $('#tweetarea').attr('value');
		if(text != '')
		{
			$('#button').attr('disabled', false);
		}
		else
		{
			$('#button').attr('disabled', true);
		}
	});
	
	
	//Följ/Sluta följ användare
	$('#followbutton').click(function()
	{
		var follow = '';
		var path = window.location.href;
		if($('#followbutton').val() == 'Följ')
		{
			
			$('#followbutton').attr('value', 'Sluta följ');
			$('#following').text('Följer');
			follow = 'true';
			
		}
		else
		{
			$('#followbutton').attr('value', 'Följ');
			$('#following').text('Följer inte');
			follow = 'false'
		}
		
		$.ajax({
			url: path,
			type: 'POST',
			data: { follow : follow},
		}); 
	});
	
	
	//Visa fler tweets
	$('#moretweets').click(function() {
		var pathname = window.location.pathname;
		$('#loading').html('Laddar');
		tweetsShowing += 10;
		
		if(pathname == '/tweets/myflow')
		{
			$.ajax(
			{
				url: '/tweets/writetweets',
				type: 'POST',
				data: {tweets: tweetsShowing, flow: 1},
				success: function(data)
				{
					$('#innertweets').html(data);
					$('#loading').html('');
				}
				
			});
		}
		else
		{
			var id = $('#userid').text();
			$.ajax(
			{
				url: '/tweets/writetweets',
				type: 'POST',
				data: {tweets: tweetsShowing, userid: id},
				success: function(data)
				{
					$('#innertweets').html(data);
					$('#loading').html('');
				}
				
			});
		}
	});
	
	
	//Knappen posta
	$('#button').click(function()
	{
		tweetsShowing = 10;
		$('#feedback').text('Laddar');
	});
	
	//Posta en tweet med ajaxForm
	$('#form').ajaxForm({
		target: '#innertweets',
		success: function clearTweet()
		{
			$('#tweetarea').attr('value', '');
			$('#feedback').text('');
			$('#button').attr('disabled', true);
		}
	});
	
	//Tweets blir highlightade när man drar musen över
	$('.tweetbox').bind('mouseenter mouseleave', function()
	{
		$(this).toggleClass('lightgrey');
	});

	
	//Klicka på ett tweet
	$('.clickableTweet').toggle(function()
	{
		$(this).parent().parent().find('.replylink').html('<a class="replylink" href="#">Svara</a>');
		$(this).parent().parent().find('.tweetsabove').slideDown();
		$(this).parent().parent().find('.tweetsbelow').slideDown();
		$(this).parent().parent().find('.form2').html('');
		
	}, function()
	{
		$(this).parent().parent().find('.replylink').html('');
		$(this).parent().parent().find('.tweetsabove').slideUp();
		$(this).parent().parent().find('.tweetsbelow').slideUp();
	});
	
	
	//Klicka på länken "svara"
	$('.replylink').click(function()
	{
		$(this).parent().find('.form2').html('<br /><form id="replyform" action="#" method="POST"><input id="replyid" class="invisible" type="text" name="id" value="' + $(this).parent().find('.invisible').text() + '" /><textarea id="tweetarea" name="message"></textarea><br /><input id="replybutton" type="button" class="btn btn-primary" value="Posta" /><div id="feedback"></div></form>');
		
		return false;
	});

	
	//Posta svaret
	$('body').on('click', '#replybutton', function()
	{
		var tweettext = $(this).parent().parent().find('#tweetarea').val();
		var tweetid = $(this).parent().parent().parent().find('#id').text()
		var userid = $('#userid').text();
		$('#replybutton').css('display', 'none');
		$('#replybutton').after('Laddar');
		
		if(userid != "")
		{
			$.post('/tweets/writetweets', { message: tweettext, id: tweetid, userid: userid },
				function(data)
				{
					$('#innertweets').html(data);
				}
			);
		}
		else
		{
			$.post('/tweets/writetweets', { message: tweettext, id: tweetid, flow: 1 },
				function(data)
				{
					$('#innertweets').html(data);
				}
			);
		}
	});
});




