/**
 * Replace plugin for Cleditor
 *
 * @version 1.0
 * @author Ivan Scherbak <funivan@t5.org.ua>
 */
(function ($) {

  // Define the replacer button
  $.cleditor.buttons.replacer = {
    name: "replacer",
    css: {
      background: 'url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABIAAAASCAYAAABWzo5XAAABfUlEQVQ4y62UT2rCUBDGfynZBAWpIEVKqRSJblyJC72Dh+iii1ygi9qFq16it4gnUHBVXIkmm0IgiCB1pUaKZF4XJRI1VgsODO/PzHx8M2/eaEopLiF6/NDpdE6iNptNLdGglEIphW3bSkQSNQxD5Xme6na7yrZtFcXE9WofeLFYHOhyucT3fRqNBkEQJDLXk1gOBgPW6zWGYZBOpymVSsxmM1qtFtPpFN/3AVQ8zUSgarV6kH6tVsN1XUajIePxmLMY9Xo9crkcq9WKIAioVCpkMhksy8KyLBzHYT6f/w0kItvAeGtEexEhqWX0pBccDocUCgU8z8MwDABSqRQAxWLxNFAEVq/XAcjn89ug+Coip4FEBMdxADBNk/bb+469/fJ0PqNyubzjfH/3wOpb+Jp52/T35eoYI9d1CcMQgMKNxu21nF/siJFpmjvO3Y/PXxvqKCP92N+L5PX58f/F7vf7bDabg97ZZzCZTMhmszt3WtzpnDFybJxolxpsP+qTJc+iAVcOAAAAAElFTkSuQmCC) center center no-repeat '
    },
    title: "replacer Html",
    command: "inserthtml",
    buttonClick: makeCleanCode,
    regex: [
      [/\s*class\s*=\s*("|')MsoNormal("|')/ig, ''],
      [/<[a-z]+:[a-z]+>/ig, ''],
      [/\s*style\s*=\s*("|')(?!text-align)([^"']+)("|')/ig, ''],
      [/<(font)[^>]*>/mig, '<$1>'],
      [/<(font)[^>]*>\n*(.*)\n*<\/(font)>/mig, '$2'],
      [/<p[^>]*><br[^>]*><\/p>/mig, ''],
      [/<([^>])>\s*<\s*\/[^>]>/mgi, ''],
      [/&nbsp;/gi, " "],
      [/<div[^>]*>/gi, '<p>'],
      [/<\/div>/gi, '</p>'],
      [/<br>\s*\n*<br>/gi, '<br>'],
      [/<br>\s*\n*<\/(strong)>/gi, '</$1><br>'],
      [/<(h\d)>\s*\n*<(strong|span)>/gi, '<$1>'],
      [/<\/strong>\s*\n*<\/(h\d)>/gi, '</$1>'],
      [/<(strong)>\s*\n*<br>/gi, '<br><$1>'],
      [/<[\/]*(font|span)[^>]*>/gi, ''],
      [/<([\/]*)b>/gi, '<$1strong>'],
      [/times="" new="" roman";"=""/gi, ''],
      [/\n/gi, ' '],
      [/  /gi, ' '],
      [/(«|»)/g, '"'],
    ],
    beforeReplace: function () {
    },
    afterReplace: function () {
    }
  };

  // default add button
  $.cleditor.defaultOptions.controls = $.cleditor.defaultOptions.controls.replace("bold", "replacer bold");

  // Handle the replacer button click event
  function makeCleanCode(e, data) {

    // Get the editor
    var editor = data.editor;

    // Get code
    var code = editor.$area.val();

    this.beforeReplace();

    var maxIterations = 4;
    var i = maxIterations;
    do {
      var oldCode = code
      $.each(this.regex, function (index, item) {
        code = code.replace(item[0], item[1]);
      });

      var allTags = code.match(/<([a-z]+)>/g);
      if (allTags > 0) {
        $.each(jQuery.unique(allTags), function (index, item) {
          // delete double tags
          var item = item.replace(/[<|>]/g, '');
          code = code.replace('<' + item + '>\n*\s*\n*<' + item + '>', '<' + item + '>');
          code = code.replace('</' + item + '>\n*\s*\n*</' + item + '>', '</' + item + '>');
        });
      }


      if (oldCode == code) {
        i--;
      } else {
        i = maxIterations;
      }
    } while (i > 0)

    this.afterReplace();
    // Set code
    editor.$area.val(code);
    editor.updateFrame();
    editor.focus();
    return false;
  }

})(jQuery);