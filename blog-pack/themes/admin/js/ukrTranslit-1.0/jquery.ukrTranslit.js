(function ($) {
  /**
   * 1.0
   * @author funivan <dev@funivan.com>
   * $('#title').ukrTranslit('#sef');
   *
   */
  $.fn.extend({
    ukrTranslit: function (el) {
      var translitTable = new Array();
      translitTable['а'] = 'a';
      translitTable['А'] = 'A';
      translitTable['б'] = 'b';
      translitTable['Б'] = 'B';
      translitTable['в'] = 'v';
      translitTable['В'] = 'V';
      translitTable['зг'] = 'gh';
      translitTable['Зг'] = 'Gh';
      translitTable['ЗГ'] = 'GH';
      translitTable['г'] = 'h';
      translitTable['Г'] = 'H';
      translitTable['ґ'] = 'g';
      translitTable['Ґ'] = 'G';
      translitTable['д'] = 'd';
      translitTable['Д'] = 'D';
      translitTable['е'] = 'e';
      translitTable['Е'] = 'E';
      translitTable[' є'] = ' ye';
      translitTable[' Є'] = ' Ye';
      translitTable['є'] = 'ie';
      translitTable['Є'] = 'IE';
      translitTable['ж'] = 'zh';
      translitTable['Ж'] = 'Zh';
      translitTable['з'] = 'z';
      translitTable['З'] = 'Z';
      translitTable['и'] = 'y';
      translitTable['И'] = 'Y';
      translitTable['і'] = 'i';
      translitTable['І'] = 'I';
      translitTable[' ї'] = ' yi';
      translitTable[' Ї'] = ' Yi';
      translitTable['ї'] = 'i';
      translitTable['Ї'] = 'I';
      translitTable[' й'] = ' y';
      translitTable[' Й'] = ' Y';
      translitTable['й'] = 'i';
      translitTable['Й'] = 'I';
      translitTable['к'] = 'k';
      translitTable['К'] = 'K';
      translitTable['л'] = 'l';
      translitTable['Л'] = 'L';
      translitTable['м'] = 'm';
      translitTable['М'] = 'M';
      translitTable['н'] = 'n';
      translitTable['Н'] = 'N';
      translitTable['о'] = 'o';
      translitTable['О'] = 'O';
      translitTable['п'] = 'p';
      translitTable['П'] = 'P';
      translitTable['р'] = 'r';
      translitTable['Р'] = 'R';
      translitTable['с'] = 's';
      translitTable['С'] = 'S';
      translitTable['т'] = 't';
      translitTable['Т'] = 'T';
      translitTable['у'] = 'u';
      translitTable['У'] = 'U';
      translitTable['ф'] = 'f';
      translitTable['Ф'] = 'F';
      translitTable['х'] = 'kh';
      translitTable['Х'] = 'Kh';
      translitTable['ц'] = 'ts';
      translitTable['Ц'] = 'Ts';
      translitTable['ч'] = 'ch';
      translitTable['Ч'] = 'Ch';
      translitTable['ш'] = 'sh';
      translitTable['Ш'] = 'Sh';
      translitTable['щ'] = 'shch';
      translitTable['Щ'] = 'Shch';
      translitTable['ь'] = '';
      translitTable['Ь'] = '';
      translitTable[' ю'] = ' yu';
      translitTable[' Ю'] = ' Yu';
      translitTable['ю'] = 'iu';
      translitTable['Ю'] = 'Iu';
      translitTable[' я'] = ' ya';
      translitTable[' Я'] = ' Ya';
      translitTable['я'] = 'ia';
      translitTable['Я'] = 'Ia';

      var el = $(el);

      $(this).keyup(function () {
        var text = $(this).val();
        for (from in translitTable) {
          var regexp = new RegExp(from, 'g');
          text = text.replace(regexp, translitTable[from]);
        }
        text = text.toLowerCase();
        text = text.replace(/ /g, '-');
        text = text.replace(/[^a-z0-9\-]/g, '');
        text = text.replace(/-{2,}/g, '-');

        text = text.replace(/^[-]+/g, '');
        text = text.replace(/[-]+$/g, '');

        el.val(text);
      });

    }
  });

})(jQuery);
