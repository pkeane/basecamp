var App = {};

$(document).ready(function() {
	App.initDelete('topMenu');
	App.initDelete('homeContent');
	App.initPut('homeContent');
	App.initToggle('homeContent');
	App.editProjectNote();
	App.initMyNotes();
	App.initPostNote();
});

App.editProjectNote = function() {
	$('#project_notes a').click( function() {
		$('#project_notes_form').toggle();
		$('#project_notes').toggle();
		return false;
	});
};

App.initMyNotes = function() {
	$.getJSON($('#my_notes').attr('href'),null,function(data) {
		var html = ''
		for (var i=0;i<data.length;i++) {
			var note = data[i];
			html += '<dt>'+note.timestamp;
			if (note.project_name) {
				html += ' : <a href="'+note.project_url+'">'+note.project_name+'</a>';
			}
			html += '</dt><dd>';
			html += note.text;
			if (note.project_basecamp_id) {
				html += ' <a href="project\/'+note.project_basecamp_id+'\/note\/'+note.id+'" class="delete">[X]</a>';
			}
			html += '</dd>';
		}
		$('#my_notes').html(html);
		App.initDelete('my_notes');
	});
};

App.initPostNote = function() {
	$('#my_notes_form').submit(function() {
		var textarea = $(this).find('textarea');
		var note = textarea.val();
			var post_o = {
				'url': $(this).attr('action'),
				'type':'POST',
				'data':note,
				'dataType':'text/plain',
				'success': function() {
					textarea.val('');
					App.initMyNotes();
				},
				'error': function() {
					alert('sorry, there was an error');
				}
			};
			$.ajax(post_o);
			return false;
	});
};

App.initToggle = function(id,second_target) {
	$('#'+id).find('a[class="toggle"]').click(function() {
		var id = $(this).attr('id');
		var tar = id.replace('toggle','target');
		$('#'+tar).toggle();
		//for second target
		$('#'+tar+'2').toggle();
		return false;
	});	
};

App.initDelete = function(id) {
	$('#'+id).find("a[class='delete']").click(function() {
		if (confirm('are you sure?')) {
			var del_o = {
				'url': $(this).attr('href'),
				'type':'DELETE',
				'success': function() {
					location.reload();
				},
				'error': function() {
					alert('sorry, cannot delete');
				}
			};
			$.ajax(del_o);
		}
		return false;
	});
};

App.initPut = function(id) {
	$('#'+id).find("a[class='put']").click(function() {
		var put_o = {
			'url': $(this).attr('href'),
			'type':'PUT',
			'success': function() {
				location.reload();
			},
			'error': function() {
				alert('sorry, there was an error');
			}
		};
		$.ajax(put_o);
		return false;
	});
};
