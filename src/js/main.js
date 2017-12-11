$(document).ready(function () {

  $('.send-form').submit(function () {
    var th = $(this);
    $.ajax({
      type: 'GET',
      url: 'add_comment.php',
      data: th.serialize()
    }).done(function () {
      alert('comment send!');
      setTimeout(function () {
        th.trigger('reset');
      }, 1000)
    });
    return false;
  });

  $('.get_comments').on('click', function () {
    $.get("read_comments.php", function (data) {
      console.log(data);
    })
  });

});