(function ($) {
  var hidden_frame_name = '__upload_iframe';
  // Define the image button by replacing the standard one
  $.cleditor.buttons.image = {
    name: 'image',
    title: 'Insert/Upload Image',
    command: 'insertimage',
    popupName: 'image',
    popupClass: 'cleditorPrompt',
    stripIndex: $.cleditor.buttons.image.stripIndex,
    popupContent: '<iframe style="width:0;height:0;border:0;" name="' + hidden_frame_name + '" />' +
      '<table cellpadding="0" cellspacing="0">' +
      '<tr><td>Choose a File:</td></tr>' +
      '<tr><td> ' +
      '<form method="post" enctype="multipart/form-data" action="" target="' + hidden_frame_name + '">' +
      '<input id="imageName" name="imageName" type="file" /></form> </td></tr>' +
      '<tr><td>Or enter URL:</td></tr>' +
      '<tr><td><input type="text" size="40" value="" /></td></tr>' +
      '</table><input type="button" value="Submit">',
    buttonClick: imageButtonClick,
    uploadUrl: '' // default url
  };


  function closePopup(editor) {
    editor.hidePopups();
    editor.focus();
  }

  function imageButtonClick(e, data) {
    var editor = data.editor;
    var $text = $(data.popup).find(':text');
    var $iframe = $(data.popup).find('iframe');
    var $file = $(data.popup).find(':file');

    // clear previously selected file and url
    $file.val('');
    $text.val('').focus();

    $(data.popup)
      .children(":button")
      .unbind("click")
      .bind("click", function (e) {
        var url = $.trim($text.val());
        if ($file.val()) { // proceed if any file was selected
          $iframe.bind('load', function () {
            var file_url;
            try {
              file_url = $iframe.get(0).contentWindow.document.getElementById('image').innerHTML;
            } catch (e) {
            }
            ;
            if (file_url) {
              editor.execCommand(data.command, file_url, null, data.button);
            } else {
              alert('An error occured during upload!');
            }
            $iframe.unbind('load');
            closePopup(editor);
          });
          $(data.popup).find('form').attr('action', $.cleditor.buttons.image.uploadUrl).submit();
        } else if (url != '') {
          editor.execCommand(data.command, url, null, data.button);
          closePopup(editor);
        }
      });
  }
})(jQuery);