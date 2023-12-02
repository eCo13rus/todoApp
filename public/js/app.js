$(document).ready(function () {
  $('#createTaskForm').on('submit', function (e) {
    e.preventDefault();

    // Получение значений из формы
    var creatorName = $('#creatorName').val();
    var taskName = $('#taskName').val();
    var taskDescription = $('#taskDescription').val();

    // AJAX запрос
    $.ajax({
      type: 'POST',
      url: '/tasks',
      data: {
        name: creatorName,
        title: taskName,
        description: taskDescription,
        _token: $('meta[name="csrf-token"]').attr('content')
      },
      success: function (task) {
        // Создание HTML карточки
        var newTaskHtml = '<div class="col-md-3 text-center mb-3">' +
          '<div class="card">' +
          '<h3 class="card-name">' + task.name + '</h3>' +
          '<h5 class="card-header">' + task.title + '</h5>' +
          '<div class="card-body">' +
          '<p class="card-text">' + task.description + '</p>' +
          '</div>' +
          '</div>' +
          '</div>';

        // Добавление в контейнер задач
        $('#tasksContainer').append(newTaskHtml);

        // Закрытие модального окна
        $('#createTaskForm')[0].reset();
        $('#createTaskModal').modal('hide');
      }
    });
  });
});




// Уведомление
document.addEventListener("DOMContentLoaded", function () {
  setTimeout(function () {
    $(".alert-success").slideUp(1000);
  }, 2500);
});
