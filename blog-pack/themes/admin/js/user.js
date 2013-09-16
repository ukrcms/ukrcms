$(function () {

  var menuObject = {
    hashCode: function (s) {
      return s.split("").reduce(function (a, b) {
        a = ((a << 5) - a) + b.charCodeAt(0);
        return a & a
      }, 0);
    },
    boxId: function ($box) {
      return 'box_' + $box.parent().index() + '_' + menuObject.hashCode($box.html());
    },
    items: function () {
      return $(".box .h_title");
    },
    attrName: function () {
      return 'data-box-hidden'
    },
    init: function () {
      $('li.upp').each(function () {
        var $el = $(this);
        if ($el.find('li.current').size() > 0) {
          $el.find('a:eq(0)').addClass('current');
        }
      })

      menuObject.items().each(function () {

        var $box = $(this);
        var $ul = $box.next("ul");


        $box.click(function () {
          menuObject.performAction($ul, $box);
        });

        if ($.cookie(menuObject.boxId($box)) === undefined) {
          menuObject.performAction($ul, $box);
        }
      })
    },
    performAction: function ($ul, $box) {
      if ($ul.attr(menuObject.attrName()) == 1) {
        menuObject.show($ul, $box);
      } else {
        menuObject.hide($ul, $box);
      }
    },
    show: function ($ul, $box) {
      $ul.slideDown();
      $ul.removeAttr(menuObject.attrName());
      $.cookie(menuObject.boxId($box), '1', { path: '/' });
    },
    hide: function ($ul, $box) {
      $ul.slideUp();
      $ul.attr(menuObject.attrName(), 1);
      $.removeCookie(menuObject.boxId($box), { path: '/' });
    }

  };
  menuObject.init();

  $('.confirm').click(function () {
    var txt = $(this).attr('data-confirm');
    if (typeof txt == "undefined" || txt == '') {
      txt = 'Confirm action?';
    }
    return confirm(txt);
  })

  $('#title').ukrTranslit('#sef');
  $(".cleditor").cleditor();

})
;