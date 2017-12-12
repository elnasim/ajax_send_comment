$(document).ready(function () {

  var messageForm = $(".send-form");

  messageForm.validate({
    rules: {
      name: {
        required: true
      },
      email: {
        required: true,
        email: true
      },
      message: {
        required: true,
        minlength: 5
      }
    },

    messages: {
      name: {
        required: "Укажите имя"
      },
      email: {
        required: "Укажите email",
        email: "Email введен не корректно"
      },
      message: {
        required: "Введите сообщение",
        minlength: jQuery.validator.format("Минимальная длина сообщения {0} символов!")
      }
    }

  });

  messageForm.submit(function () {
    var th = $(this);
    $.ajax({
      type: 'GET',
      url: 'add_comment.php',
      data: th.serialize(),
      success: function () {
        alert('Сообщение отправлено');
        var name = $("input[name='name']").val();
        var email = $("input[name='email']").val();
        var message = $("textarea[name='message']").val();
        $('.comments-wrapper').append('' +
            '       <div class="col-4 item-comment__wrap">\n' +
            '          <div class="item-comments">\n' +
            '            <div class="item-comments__head">' + name + '</div>\n' +
            '            <div class="item-comments__content">\n' +
            '              <div class="item-comments__email">' + email + '</div>\n' +
            '              <div class="item-comments__message">' + message + '</div>\n' +
            '            </div>\n' +
            '          </div>\n' +
            '        </div>');
        setTimeout(function () {
          th.trigger('reset');
        }, 1000)
      }
    });
    return false;
  });


});