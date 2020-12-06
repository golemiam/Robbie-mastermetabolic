/*!
 * remark (http://getbootstrapadmin.com/remark)
 * Copyright 2015 amazingsurge
 * Licensed under the Themeforest Standard Licenses
 */
(function(document, window, $) {
  'use strict';

  window.AppCalendar = App.extend({
    handleFullcalendar: function() {
      var my_options = {
        header: {
          left: null,
          center: 'prev,title,next',
          right: 'month,agendaWeek,agendaDay'
        },
//        defaultDate: '2015-10-12',
        selectable: false,
        selectHelper: false,
        editable: false,
        eventLimit: false,
        windowResize: function(view) {
          var width = $(window).outerWidth();
          var options = $.extend({}, my_options);
          options.events = view.calendar.getEventCache();
          options.aspectRatio = width < 667 ? 0.5 : 1.35;

          $('#calendar').fullCalendar('destroy');
          $('#calendar').fullCalendar(options);
        },
        events: my_events,
        droppable: false
      };

      var _options;
      var my_options_mobile = $.extend({}, my_options);

      my_options_mobile.aspectRatio = 0.5;
      _options = $(window).outerWidth() < 667 ? my_options_mobile : my_options;

      $('#editNewEvent').modal();
      $('#calendar').fullCalendar(_options);
    },

    run: function(next) {
      $('#addNewCalendarForm').modal({
        show: false
      });


      this.handleFullcalendar();

      next();
    }
  });

  $(document).ready(function() {
    AppCalendar.run();
  });
})(document, window, jQuery);
