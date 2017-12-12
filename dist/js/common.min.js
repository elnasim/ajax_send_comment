$(document).ready(function () {

  var messageForm = $(".send-form");

  function sendMessage() {

    var name = $("input[name='name']").val();
    var email = $("input[name='email']").val();
    var message = $("textarea[name='message']").val();

    $.ajax({
      type: 'GET',
      url: 'add_comment.php',
      data: messageForm.serialize(),
      resetForm: true,

      success: function () {
        alert('сообщение отправлено');

        $('.comments-wrapper').append('' +
            '       <div class="col-lg-4 col-md-6 item-comment__wrap">\n' +
            '          <div class="item-comments">\n' +
            '            <div class="item-comments__head">' + name + '</div>\n' +
            '            <div class="item-comments__content">\n' +
            '              <div class="item-comments__email">' + email + '</div>\n' +
            '              <div class="item-comments__message">' + message + '</div>\n' +
            '            </div>\n' +
            '          </div>\n' +
            '        </div>');
      }

    });
  }

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
    },

    submitHandler: function () {
      sendMessage();
    }

  });


});