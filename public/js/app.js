// Добавление задачи

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


// Обработка кликов
document.addEventListener('DOMContentLoaded', function () {
  // Делегирование событий для кликов на карточках задач
  document.getElementById('tasksContainer').addEventListener('click', function (event) {
    var card = event.target.closest('.card');
    if (card) {
      var taskId = card.getAttribute('data-task-id');
      var taskName = card.querySelector('.card-name').textContent;
      var taskTitle = card.querySelector('.card-header').textContent;
      var taskDescription = card.querySelector('.card-text').textContent;

      // Заполняем форму данными
      document.getElementById('editTaskId').value = taskId;
      document.getElementById('editTaskName').value = taskName;
      document.getElementById('editTaskTitle').value = taskTitle;
      document.getElementById('editTaskDescription').value = taskDescription;

      // Показываем модальное окно
      var taskModal = new bootstrap.Modal(document.getElementById('taskModal'));
      taskModal.show();
    }
  });
});




// Обработка отправки формы редактирования
document.addEventListener('DOMContentLoaded', function () {
  document.getElementById('editTaskForm').addEventListener('submit', function (e) {
    e.preventDefault();

    var taskId = document.getElementById('editTaskId').value;
    var taskName = document.getElementById('editTaskName').value;
    var taskTitle = document.getElementById('editTaskTitle').value;
    var taskDescription = document.getElementById('editTaskDescription').value;

    fetch('/tasks/' + taskId, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
      },
      body: JSON.stringify({
        name: taskName,
        title: taskTitle,
        description: taskDescription,
        _method: 'PUT'
      })
    }).then(response => response.json())
      .then(data => {
        // Найти элемент задачи с соответствующим data-task-id
        var taskElement = document.querySelector('[data-task-id="' + taskId + '"]');
        if (taskElement) {
          taskElement.querySelector('.card-name').textContent = taskName;
          taskElement.querySelector('.card-header').textContent = taskTitle;
          taskElement.querySelector('.card-text').textContent = taskDescription;
        }

        // Закрыть модальное окно
        $('#taskModal').modal('hide');
      })
      .catch(error => console.error('Ошибка:', error));
  });
});






// Отправка запроса на удаление задачи
document.getElementById('deleteTaskButton').addEventListener('click', function () {
  var taskId = document.getElementById('editTaskId').value;

  fetch('/tasks/' + taskId, {
    method: 'DELETE', // Изменение метода на DELETE
    headers: {
      'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
      'Content-Type': 'application/json' // Указание типа содержимого
    }
  }).then(response => {
    if (!response.ok) {
      throw new Error('Ошибка запроса: ' + response.statusText);
    }
    return response.json();
  })
    .then(data => {
      console.log(data);
      // Закрыть модальное окно
      var taskModal = bootstrap.Modal.getInstance(document.getElementById('taskModal'));
      taskModal.hide();
      // Удалить элемент задачи с страницы (если необходимо)
    })
    .catch(error => console.error('Ошибка:', error));
});

