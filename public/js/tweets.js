$(document).ready(function()
{
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
		
		$('#loading').html('Laddar');
		tweetsShowing += 10;
		//$('#tweetsShowing').text(tweetsShowing);
		
		$.ajax(
		{
			url: '/tweets/writetweets',
			type: 'POST',
			data: {tweets: tweetsShowing},
			success: function(data)
			{
				$('#innertweets').html(data);
				$('#loading').html('');
			}
			
		});
	});
	
	
	//Posta en tweet
	$('#button').click(function()
	{
		tweetsShowing = 10;
		$('#feedback').text('Laddar');
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
	
	//Klicka på svara
	$('.replylink').click(function()
	{
		//$(this).parent().find('.form2').html('Hej');
		$(this).parent().find('.form2').html('<br /><form id="replyform" action="#" method="POST"><input id="replyid" class="invisible" type="text" name="id" value="' + $(this).parent().find('.invisible').text() + '" /><textarea id="tweetarea" name="message"></textarea><br /><input id="replybutton" type="button" class="btn btn-primary" value="Posta" /><div id="feedback"></div></form>');
		
		return false;
	});

	
	//Posta svaret
	$('body').on('click', '#replybutton', function()
	{
	
		var tweettext = $(this).parent().parent().find('#tweetarea').val();
		var tweetid = $(this).parent().parent().parent().find('.invisible').text()
		//var tweetid = $(this).parent().parent().find.('#replyid').val();
		
		$('#feedback').text('message: ' + tweettext + ' id: ' + tweetid);
		
		$.post('/tweets/writetweets', { message: tweettext, id: tweetid },
			function(data)
			{
				$('#feedback').html('Vi har postat');
				$('#innertweets').html(data);
			}
		);
	});
	
});




